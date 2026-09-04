<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quote;
use App\Services\InvoiceJournalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    protected array $statusLabels = [
        'draft'    => 'Draft',
        'sent'     => 'Terkirim',
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
        'expired'  => 'Kedaluwarsa',
    ];

    public function __construct(private InvoiceJournalService $journal)
    {
    }

    public function index(Request $request)
    {
        $company = Auth::user()->company;
        $companyId = $company->id;

        $query = Quote::where('company_id', $companyId)->with(['client', 'invoice']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('quote_number', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('issue_date', '>=', $request->from);
        }

        $quotes = $query->orderByDesc('issue_date')->paginate(15)->withQueryString();

        $stats = [
            'total_count'     => Quote::where('company_id', $companyId)->count(),
            'total_amount'    => Quote::where('company_id', $companyId)->sum('total'),
            'sent_count'      => Quote::where('company_id', $companyId)->where('status', 'sent')->count(),
            'sent_amount'     => Quote::where('company_id', $companyId)->where('status', 'sent')->sum('total'),
            'accepted_count'  => Quote::where('company_id', $companyId)->where('status', 'accepted')->count(),
            'accepted_amount' => Quote::where('company_id', $companyId)->where('status', 'accepted')->sum('total'),
            'expired_count'   => Quote::where('company_id', $companyId)
                ->where('status', 'sent')
                ->whereDate('valid_until', '<', now())
                ->count(),
            'expired_amount'  => Quote::where('company_id', $companyId)
                ->where('status', 'sent')
                ->whereDate('valid_until', '<', now())
                ->sum('total'),
        ];

        $statusLabels = $this->statusLabels;

        return view('quotes.index', compact('quotes', 'stats', 'company', 'statusLabels'));
    }

    public function create()
    {
        $company = Auth::user()->company;
        $clients = Client::where('company_id', $company->id)->orderBy('name')->get();

        return view('quotes.create', compact('clients', 'company'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['company_id'] = Auth::user()->company->id;

        Quote::create($data);

        return redirect()->route('quotes.index')->with('success', 'Penawaran berhasil dibuat.');
    }

    public function show(Quote $quote)
    {
        $company = Auth::user()->company;
        $quote->load('invoice');

        return view('quotes.show', compact('quote', 'company'));
    }

    public function edit(Quote $quote)
    {
        $company = Auth::user()->company;
        $clients = Client::where('company_id', $company->id)->orderBy('name')->get();

        return view('quotes.edit', compact('quote', 'clients', 'company'));
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $this->validateData($request);

        $quote->update($data);

        return redirect()->route('quotes.index')->with('success', 'Penawaran berhasil diperbarui.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Penawaran berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        Quote::where('company_id', Auth::user()->company->id)
            ->whereIn('id', $ids)
            ->delete();

        return redirect()->route('quotes.index')->with('success', 'Penawaran terpilih berhasil dihapus.');
    }

    /**
     * Konversi Penawaran jadi Faktur. Faktur baru langsung berstatus "sent",
     * jadi otomatis posting jurnal Piutang Usaha lewat InvoiceJournalService.
     * Idempotent: kalau quote sudah pernah dikonversi, nggak bikin faktur baru.
     */
    public function convertToInvoice(Quote $quote)
    {
        $user = Auth::user();
        $company = $user->company;

        abort_unless($quote->company_id === $company->id, 403);

        if ($quote->invoice_id) {
            return redirect()
                ->route('quotes.show', $quote)
                ->with('error', 'Penawaran ini sudah pernah dikonversi jadi Faktur ' . optional($quote->invoice)->invoice_number . '.');
        }

        if (!$quote->client_id) {
            return redirect()
                ->route('quotes.show', $quote)
                ->with('error', 'Penawaran ini belum punya klien, tidak bisa dikonversi jadi faktur.');
        }

        $invoiceController = app(InvoiceController::class);

        $invoice = Invoice::create([
            'company_id'     => $company->id,
            'client_id'      => $quote->client_id,
            'invoice_number' => $invoiceController->generateInvoiceNumber($company->id),
            'issue_date'     => now()->toDateString(),
            'due_date'       => now()->addDays(30)->toDateString(),
            'subtotal'       => $quote->subtotal,
            'tax_amount'     => $quote->tax_amount,
            'total'          => $quote->total,
            'status'         => 'sent',
            'notes'          => 'Dikonversi dari penawaran ' . $quote->quote_number,
            'items'          => json_encode([]),
            'created_by'     => $user->id,
        ]);

        // Faktur langsung "sent" -> piutang diakui di Buku Besar.
        $this->journal->syncReceivableRecognitionJournal($company, $invoice);

        $quote->update([
            'status'     => 'accepted',
            'invoice_id' => $invoice->id,
        ]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Penawaran ' . $quote->quote_number . ' berhasil dikonversi jadi Faktur ' . $invoice->invoice_number . '.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'client_id'   => ['required', 'exists:clients,id'],
            'issue_date'  => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after_or_equal:issue_date'],
            'status'      => ['required', 'in:draft,sent,accepted,rejected,expired'],
            'subtotal'    => ['required', 'numeric', 'min:0'],
            'tax_amount'  => ['nullable', 'numeric', 'min:0'],
            'notes'       => ['nullable', 'string'],
        ]);
    }
}