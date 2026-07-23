<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        // ===== BUILD QUERY =====
        $query = Invoice::with('client')->where('company_id', $company->id);

        // Filter by search query
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('invoice_number', 'like', "%{$q}%")
                    ->orWhereHas('client', function ($client) use ($q) {
                        $client->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by status (including virtual "overdue")
        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                // Overdue = status 'sent' AND due_date < now
                $query->where('status', 'sent')
                      ->where('due_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        $query->orderBy('created_at', 'desc');
        $invoices = $query->paginate(15)->withQueryString();

        // ===== CALCULATE STATS (BASED ON FILTERED DATA) =====
        $statsQuery = Invoice::with('client')->where('company_id', $company->id);

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

        $itemsRule = class_exists(\App\Models\Item::class) ? 'exists:items,id' : 'nullable';

        $validated = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'issue_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:issue_date',
            // Items dikirim sebagai checkbox berisi ID barang dari katalog,
            // BUKAN sebagai objek description/quantity/price.
            'items'       => 'nullable|array',
            'items.*'     => $itemsRule,
            'subtotal'    => 'nullable|numeric|min:0',
            'tax'         => 'nullable|numeric|min:0',
            'total'       => 'required|numeric|min:0',
            'notes'       => 'nullable|string',
            'description' => 'nullable|string',
            'terms'       => 'nullable|string',
        ]);

        // Nomor faktur DIBUAT DI SERVER, bukan dari input form.
        // (Input di form create bersifat "disabled" untuk ditampilkan saja,
        // sehingga tidak pernah ikut terkirim -- jangan andalkan itu.)
        $invoiceNumber = $this->generateInvoiceNumber($company->id);

        // Bangun daftar item dari ID yang dicentang di checkbox.
        [$formattedItems, $itemsSubtotal] = $this->buildItemsFromIds($request->input('items', []));

        $subtotal = $validated['subtotal'] ?? ($itemsSubtotal > 0 ? $itemsSubtotal : $validated['total']);
        $tax      = $validated['tax'] ?? 0;

        $invoice = Invoice::create([
            'company_id'     => $company->id,
            'client_id'      => $validated['client_id'],
            'invoice_number' => $invoiceNumber,
            'issue_date'     => $validated['issue_date'],
            'due_date'       => $validated['due_date'],
            'items'          => json_encode($formattedItems),
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'total'          => $validated['total'],
            'notes'          => $validated['notes'] ?? $validated['description'] ?? null,
            'terms'          => $validated['terms'] ?? null,
            'status'         => 'draft',
            'created_by'     => $user->id,
        ]);

        return redirect()->route('invoices.index')
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

        // Hanya faktur berstatus draft yang boleh diedit.
        if ($invoice->status !== 'draft') {
            return redirect()->route('invoices.index')
                ->with('error', 'Faktur dengan status "' . $invoice->status . '" tidak dapat diedit.');
        }

        $itemsRule = class_exists(\App\Models\Item::class) ? 'exists:items,id' : 'nullable';

        $validated = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date'   => 'required|date|after_or_equal:issue_date',
            // Sama seperti store(): items adalah array ID barang dari checkbox.
            'items'      => 'nullable|array',
            'items.*'    => $itemsRule,
            'subtotal'   => 'required|numeric|min:0',
            'tax'        => 'nullable|numeric|min:0',
            'total'      => 'required|numeric|min:0',
            'status'     => 'required|in:draft,sent,paid,cancelled',
            'notes'      => 'nullable|string',
            'terms'      => 'nullable|string',
        ]);

        [$formattedItems] = $this->buildItemsFromIds($request->input('items', []));

        $invoice->update([
            'client_id'  => $validated['client_id'],
            'issue_date' => $validated['issue_date'],
            'due_date'   => $validated['due_date'],
            'items'      => json_encode($formattedItems),
            'subtotal'   => $validated['subtotal'],
            'tax'        => $validated['tax'] ?? 0,
            'total'      => $validated['total'],
            'status'     => $validated['status'],
            'notes'      => $validated['notes'] ?? null,
            'terms'      => $validated['terms'] ?? null,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Faktur ' . $invoice->invoice_number . ' berhasil diperbarui!');
    }

    public function destroy(Invoice $invoice)
    {
        $user = Auth::user();
        $company = $user->company;

        if ($invoice->company_id !== $company->id) {
            abort(403);
        }

        // Cek apakah faktur bisa dihapus
        if (!in_array($invoice->status, ['draft', 'cancelled'])) {
            return redirect()->route('invoices.index')
                ->with('error', 'Faktur dengan status "' . $invoice->status . '" tidak dapat dihapus.');
        }

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Faktur ' . $invoice->invoice_number . ' berhasil dihapus!');
    }

    public function export(Request $request)
    {
        return redirect()->route('invoices.index')
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

            $invoice->status = 'sent';
            $invoice->save();

            return response()->json([
                'success' => true,
                'message' => 'Faktur ' . $invoice->invoice_number . ' berhasil dikirim (status diubah menjadi Terkirim).'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim faktur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buat nomor faktur baru berbasis tanggal + urutan.
     * Dipakai baik saat menampilkan form create (preview)
     * maupun saat benar-benar menyimpan (final).
     */
    private function generateInvoiceNumber(int $companyId): string
    {
        $lastInvoice = Invoice::where('company_id', $companyId)
            ->orderBy('id', 'desc')
            ->first();

        return 'INV-' . date('Ymd') . '-' . str_pad(
            ($lastInvoice ? $lastInvoice->id + 1 : 1),
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * Ubah array ID item (dari checkbox) menjadi array baris item lengkap
     * (id, name, description, quantity, price), dan hitung subtotalnya.
     *
     * Aman dipanggil walau model App\Models\Item belum ada di project --
     * dalam kondisi itu, fungsi ini akan mengembalikan array kosong
     * sehingga tidak menyebabkan error.
     *
     * @param  array $itemIds
     * @return array [formattedItems, subtotal]
     */
    private function buildItemsFromIds(array $itemIds): array
    {
        if (empty($itemIds) || !class_exists(\App\Models\Item::class)) {
            return [[], 0];
        }

        $itemModel = \App\Models\Item::class;
        $items = $itemModel::whereIn('id', $itemIds)->get();

        $formattedItems = [];
        $subtotal = 0;

        foreach ($items as $item) {
            $qty = 1;
            $price = $item->price ?? 0;

            $formattedItems[] = [
                'id'          => $item->id,
                'name'        => $item->name,
                'description' => $item->description ?? $item->name,
                'quantity'    => $qty,
                'price'       => $price,
            ];

            $subtotal += $qty * $price;
        }

        return [$formattedItems, $subtotal];
    }

    /**
     * Ambil daftar item milik company, untuk ditampilkan sebagai checklist
     * di form create/edit. Mengembalikan collection kosong jika model
     * App\Models\Item belum ada di project (fitur katalog item belum dipakai).
     */
    private function getCompanyItems(int $companyId)
    {
        if (!class_exists(\App\Models\Item::class)) {
            return collect();
        }

        $itemModel = \App\Models\Item::class;

        return $itemModel::where('company_id', $companyId)->get();
    }
}