<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Invoice;
use App\Models\Client;
use App\Services\InvoiceJournalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Batas maksimal nominal total faktur.
     * Kolom `subtotal`, `tax_amount`, `total` di tabel invoices bertipe decimal(15,2).
     */
    private const MAX_TOTAL = 9999999999999.99;

    public function __construct(private InvoiceJournalService $journal)
    {
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Invoice::with('client')->where('company_id', $company->id);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('invoice_number', 'like', "%{$q}%")
                    ->orWhereHas('client', function ($client) use ($q) {
                        $client->where('name', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $query->where('status', 'sent')
                      ->where('due_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        $query->orderBy('created_at', 'desc');
        $invoices = $query->paginate(15)->withQueryString();

        $statsQuery = Invoice::where('company_id', $company->id);

        if ($request->filled('q')) {
            $q = $request->q;
            $statsQuery->where(function ($sub) use ($q) {
                $sub->where('invoice_number', 'like', "%{$q}%")
                    ->orWhereHas('client', function ($client) use ($q) {
                        $client->where('name', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $statsQuery->where('status', 'sent')
                          ->where('due_date', '<', now());
            } else {
                $statsQuery->where('status', $request->status);
            }
        }

        $filteredIds = $statsQuery->pluck('id');

        $stats = [
            'total_amount' => Invoice::whereIn('id', $filteredIds)->sum('total'),
            'total_count' => Invoice::whereIn('id', $filteredIds)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'paid_amount' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'paid')
                ->sum('total'),
            'paid_count' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'paid')
                ->count(),
            'outstanding_amount' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'sent')
                ->sum('total'),
            'outstanding_count' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'sent')
                ->count(),
            'overdue_amount' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'sent')
                ->where('due_date', '<', now())
                ->sum('total'),
            'overdue_count' => Invoice::whereIn('id', $filteredIds)
                ->where('status', 'sent')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return view('invoices.index', compact('invoices', 'stats', 'company'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        $clients = Client::where('company_id', $company->id)->get();
        $items = $this->getCompanyItems($company->id);
        $nextInvoiceNumber = $this->generateInvoiceNumber($company->id);

        return view('invoices.create', compact('company', 'clients', 'items', 'nextInvoiceNumber'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $validated = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'issue_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:issue_date',
            'subtotal'    => 'nullable|numeric|min:0|max:' . self::MAX_TOTAL,
            'tax_amount'  => 'nullable|numeric|min:0|max:' . self::MAX_TOTAL,
            'total'       => 'required|numeric|min:0|max:' . self::MAX_TOTAL,
            'status'      => 'required|in:draft,sent,paid,cancelled',
            'notes'       => 'nullable|string|max:500',
            'items'       => 'nullable|array',
        ], [
            'total.max'       => 'Total faktur tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
            'subtotal.max'    => 'Subtotal tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
            'tax_amount.max'  => 'Nilai pajak tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
        ]);

        $invoiceNumber = $this->generateInvoiceNumber($company->id);

        $itemsData = [];
        if (!empty($validated['items'])) {
            $itemsData = $this->buildItemsFromIds($validated['items']);
        }

        $invoice = Invoice::create([
            'company_id'     => $company->id,
            'client_id'      => $validated['client_id'],
            'invoice_number' => $invoiceNumber,
            'issue_date'     => $validated['issue_date'],
            'due_date'       => $validated['due_date'],
            'subtotal'       => $validated['subtotal'] ?? 0,
            'tax_amount'     => $validated['tax_amount'] ?? 0,
            'total'          => $validated['total'],
            'status'         => $validated['status'],
            'notes'          => $validated['notes'] ?? null,
            'items'          => json_encode($itemsData),
            'created_by'     => $user->id,
        ]);

        // Kalau faktur langsung dibuat berstatus "sent"/"paid", piutang langsung dicatat di Buku Besar.
        if (in_array($invoice->status, ['sent', 'paid'])) {
            $this->journal->syncReceivableRecognitionJournal($company, $invoice);
        }
        if ($invoice->status === 'paid') {
            $this->journal->syncReceivablePaymentJournal($company, $invoice);
        }

        $this->logActivity('created', 'Menambahkan faktur: ' . $invoice->invoice_number, $invoice);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Faktur ' . $invoice->invoice_number . ' berhasil dibuat!');
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        $company = $user->company;

        if ($invoice->company_id !== $company->id) {
            abort(403);
        }

        $invoice->load('client');
        $invoice->items = json_decode($invoice->items, true) ?? [];

        return view('invoices.show', compact('invoice', 'company'));
    }

    public function edit(Invoice $invoice)
    {
        $user = Auth::user();
        $company = $user->company;

        if ($invoice->company_id !== $company->id) {
            abort(403);
        }

        $clients = Client::where('company_id', $company->id)->get();
        $items = $this->getCompanyItems($company->id);
        $invoice->items = json_decode($invoice->items, true) ?? [];

        return view('invoices.edit', compact('invoice', 'company', 'clients', 'items'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $user = Auth::user();
        $company = $user->company;

        if ($invoice->company_id !== $company->id) {
            abort(403);
        }

        // Simpan status LAMA sebelum di-update, buat tau transisinya.
        $wasRecognized = in_array($invoice->status, ['sent', 'paid']);
        $wasPaid = $invoice->status === 'paid';

        $validated = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'issue_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:issue_date',
            'subtotal'    => 'nullable|numeric|min:0|max:' . self::MAX_TOTAL,
            'tax_amount'  => 'nullable|numeric|min:0|max:' . self::MAX_TOTAL,
            'total'       => 'required|numeric|min:0|max:' . self::MAX_TOTAL,
            'status'      => 'required|in:draft,sent,paid,cancelled',
            'notes'       => 'nullable|string|max:500',
            'items'       => 'nullable|array',
        ], [
            'total.max'       => 'Total faktur tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
            'subtotal.max'    => 'Subtotal tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
            'tax_amount.max'  => 'Nilai pajak tidak boleh melebihi Rp' . number_format(self::MAX_TOTAL, 0, ',', '.') . '.',
        ]);

        $itemsData = [];
        if (!empty($validated['items'])) {
            $itemsData = $this->buildItemsFromIds($validated['items']);
        }

        $invoice->update([
            'client_id'  => $validated['client_id'],
            'issue_date' => $validated['issue_date'],
            'due_date'   => $validated['due_date'],
            'subtotal'   => $validated['subtotal'] ?? 0,
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'total'      => $validated['total'],
            'status'     => $validated['status'],
            'notes'      => $validated['notes'] ?? null,
            'items'      => json_encode($itemsData),
        ]);

        // Sinkronkan jurnal Piutang sesuai status BARU.
        $isRecognized = in_array($invoice->status, ['sent', 'paid']);
        $isPaid = $invoice->status === 'paid';

        if ($isRecognized) {
            $this->journal->syncReceivableRecognitionJournal($company, $invoice);
        } elseif ($wasRecognized && !$isRecognized) {
            $this->journal->deleteReceivableRecognitionJournal($invoice);
        }

        if ($isPaid) {
            $this->journal->syncReceivablePaymentJournal($company, $invoice);
        } elseif ($wasPaid && !$isPaid) {
            $this->journal->deleteReceivablePaymentJournal($invoice);
        }

        $this->logActivity('updated', 'Mengupdate faktur: ' . $invoice->invoice_number, $invoice);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Faktur ' . $invoice->invoice_number . ' berhasil diperbarui!');
    }

    public function destroy(Invoice $invoice)
    {
        $user = Auth::user();
        $company = $user->company;

        if ($invoice->company_id !== $company->id) {
            abort(403);
        }

        if (!in_array($invoice->status, ['draft', 'cancelled'])) {
            return redirect()
                ->route('invoices.index')
                ->with('error', 'Faktur dengan status "' . $invoice->status . '" tidak dapat dihapus.');
        }

        // Jaga-jaga: bersihkan jurnal kalau ternyata masih ada sisa.
        $this->journal->deleteReceivableRecognitionJournal($invoice);
        $this->journal->deleteReceivablePaymentJournal($invoice);

        $invoiceNumber = $invoice->invoice_number;

        // Catat riwayat SEBELUM data dihapus, biar subject_id masih valid.
        $this->logActivity('deleted', 'Menghapus faktur: ' . $invoiceNumber, $invoice);

        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Faktur ' . $invoiceNumber . ' berhasil dihapus!');
    }

    public function export(Request $request)
    {
        return redirect()
            ->route('invoices.index')
            ->with('info', 'Fitur ekspor sedang dalam pengembangan.');
    }

    public function send(Request $request, Invoice $invoice)
    {
        try {
            $user = Auth::user();
            $company = $user->company;

            if ($invoice->company_id !== $company->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.'
                ], 403);
            }

            if ($invoice->status === 'draft') {
                $invoice->status = 'sent';
                $invoice->save();

                // Faktur resmi terkirim -> piutang diakui di Buku Besar.
                $this->journal->syncReceivableRecognitionJournal($company, $invoice);

                $this->logActivity('updated', 'Mengirim faktur: ' . $invoice->invoice_number, $invoice);

                return response()->json([
                    'success' => true,
                    'message' => 'Faktur ' . $invoice->invoice_number . ' berhasil dikirim.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Faktur dengan status "' . $invoice->status . '" tidak dapat dikirim.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim faktur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Public karena dipanggil juga dari QuoteController@convertToInvoice
     * biar format nomor faktur konsisten.
     */
    public function generateInvoiceNumber(int $companyId): string
    {
        $lastInvoice = Invoice::where('company_id', $companyId)
            ->orderBy('id', 'desc')
            ->first();

        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    private function buildItemsFromIds(array $itemIds): array
    {
        if (empty($itemIds) || !class_exists(\App\Models\Item::class)) {
            return [];
        }

        $items = \App\Models\Item::whereIn('id', $itemIds)->get();
        $formattedItems = [];

        foreach ($items as $item) {
            $formattedItems[] = [
                'id'          => $item->id,
                'name'        => $item->name,
                'description' => $item->description ?? $item->name,
                'quantity'    => $item->quantity ?? 1,
                'price'       => $item->price ?? 0,
            ];
        }

        return $formattedItems;
    }

    private function getCompanyItems(int $companyId)
    {
        if (!class_exists(\App\Models\Item::class)) {
            return collect();
        }

        return \App\Models\Item::where('company_id', $companyId)->get();
    }

    /**
     * Mencatat aktivitas ke tabel activity_logs.
     */
    protected function logActivity(string $action, string $description, $subject = null): void
    {
        ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject->id ?? null,
            'ip_address'   => request()->ip(),
        ]);
    }
}