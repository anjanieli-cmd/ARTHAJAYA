<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Tampilkan semua faktur milik company milik user yang login.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        $invoices = Invoice::with('client')
            ->where('company_id', $company->id)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('invoice_number', 'like', '%' . $request->q . '%')
                      ->orWhereHas('client', function ($cq) use ($request) {
                          $cq->where('name', 'like', '%' . $request->q . '%');
                      });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'overdue') {
                    $query->where('status', 'sent')->whereDate('due_date', '<', now());
                } else {
                    $query->where('status', $request->status);
                }
            })
            ->when($request->filled('from'), fn ($query) => $query->whereDate('issue_date', '>=', $request->from))
            ->latest('issue_date')
            ->paginate(15)
            ->withQueryString();

        $baseQuery = Invoice::where('company_id', $company->id);

        $stats = [
            'total_amount' => (clone $baseQuery)->sum('total'),
            'total_count' => (clone $baseQuery)->count(),
            'paid_amount' => (clone $baseQuery)->where('status', 'paid')->sum('total'),
            'paid_count' => (clone $baseQuery)->where('status', 'paid')->count(),
            'outstanding_amount' => (clone $baseQuery)->where('status', 'sent')->sum('total'),
            'outstanding_count' => (clone $baseQuery)->where('status', 'sent')->count(),
            'overdue_amount' => (clone $baseQuery)->where('status', 'sent')->whereDate('due_date', '<', now())->sum('total'),
            'overdue_count' => (clone $baseQuery)->where('status', 'sent')->whereDate('due_date', '<', now())->count(),
        ];

        $statusLabels = [
            'draft'     => 'Draft',
            'sent'      => 'Terkirim',
            'paid'      => 'Lunas',
            'overdue'   => 'Jatuh Tempo',
            'cancelled' => 'Dibatalkan',
        ];

        return view('invoices.index', compact('invoices', 'stats', 'statusLabels', 'company'));
    }

    /**
     * Form buat faktur baru.
     */
    public function create()
    {
        $company = auth()->user()->company;
        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        $clients = Client::where('company_id', $company->id)->orderBy('name')->get();

        return view('invoices.create', compact('company', 'clients'));
    }

    /**
     * Simpan faktur baru.
     */
    public function store(Request $request)
    {
        $company = auth()->user()->company;
        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        $data = $this->validateData($request);

        $subtotal = (float) $data['subtotal'];
        $tax = (float) ($data['tax_amount'] ?? 0);

        $invoice = Invoice::create([
            'company_id'     => $company->id,
            'client_id'      => $data['client_id'],
            'invoice_number' => Invoice::generateInvoiceNumber($company->id),
            'issue_date'     => $data['issue_date'],
            'due_date'       => $data['due_date'],
            'status'         => $data['status'] ?? 'draft',
            'subtotal'       => $subtotal,
            'tax_amount'     => $tax,
            'total'          => $subtotal + $tax,
            'notes'          => $data['notes'] ?? null,
        ]);

        return redirect()->route('invoices.show', $invoice)->with('created', true);
    }

    /**
     * Tampilkan detail satu faktur.
     */
    public function show(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->load('client', 'company');

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Form edit faktur.
     */
    public function edit(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $clients = Client::where('company_id', $invoice->company_id)->orderBy('name')->get();
        $company = $invoice->company;

        return view('invoices.edit', compact('invoice', 'clients', 'company'));
    }

    /**
     * Update faktur.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $data = $this->validateData($request);

        $subtotal = (float) $data['subtotal'];
        $tax = (float) ($data['tax_amount'] ?? 0);

        $invoice->update([
            'client_id'  => $data['client_id'],
            'issue_date' => $data['issue_date'],
            'due_date'   => $data['due_date'],
            'status'     => $data['status'] ?? $invoice->status,
            'subtotal'   => $subtotal,
            'tax_amount' => $tax,
            'total'      => $subtotal + $tax,
            'notes'      => $data['notes'] ?? null,
        ]);

        return redirect()->route('invoices.show', $invoice)->with('updated', true);
    }

    /**
     * Hapus satu faktur.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->delete();

        return redirect()->route('invoices.index')->with('deleted', true);
    }

    /**
     * Hapus banyak faktur sekaligus (bulk action dari checkbox tabel).
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:invoices,id',
        ]);

        $companyId = auth()->user()->company_id;

        Invoice::where('company_id', $companyId)
            ->whereIn('id', $request->ids)
            ->delete();

        return redirect()->route('invoices.index')->with('deleted', true);
    }

    /**
     * Pastikan faktur ini milik company user yang sedang login.
     */
    private function authorizeInvoice(Invoice $invoice): void
    {
        abort_if($invoice->company_id !== auth()->user()->company_id, 403, 'Faktur ini bukan milik perusahaanmu.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'issue_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:issue_date',
            'status'      => 'nullable|in:draft,sent,paid,overdue,cancelled',
            'subtotal'    => 'required|numeric|min:0',
            'tax_amount'  => 'nullable|numeric|min:0',
            'notes'       => 'nullable|string',
        ]);
    }
}