<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\Payable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayableController extends Controller
{
    /**
     * Daftar vendor sementara (hardcoded) -- sama seperti closure lama.
     * Ganti ke tabel `vendors` beneran kalau nanti sudah ada modelnya.
     */
    private array $vendors = [
        1 => 'Toko Bangunan Sentosa',
        2 => 'CV Kertas Nusantara',
        3 => 'Distributor Kain Batik',
        4 => 'Jasa Ekspedisi Cepat',
        5 => 'PLN - Listrik Kantor',
    ];

    /**
     * Pemetaan kategori tagihan -> kode akun COA yang jadi pasangan
     * debit saat tagihan diakui (accrual).
     */
    private array $categoryToExpenseCode = [
        'bahan_baku'   => '1-104',
        'utilitas'     => '5-101',
        'transportasi' => '5-101',
        'produksi'     => '5-101',
        'marketing'    => '5-101',
        'operasional'  => '5-101',
    ];

    /**
     * Menampilkan daftar tagihan.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        abort_if(
            ! $company,
            403,
            'Lengkapi setup perusahaan terlebih dahulu.'
        );

        $query = Payable::where('company_id', $company->id)
            ->orderBy('due');

        if ($request->filled('q')) {
            $q = strtolower($request->get('q'));

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw(
                    'LOWER(vendor) LIKE ?',
                    ["%{$q}%"]
                )->orWhereRaw(
                    'LOWER(bill_number) LIKE ?',
                    ["%{$q}%"]
                );
            });
        }

        $payables = $query->get()
            ->map(fn (Payable $p) => [
                'id' => $p->id,
                'vendor' => $p->vendor,
                'bill' => $p->bill_number,
                'date' => optional($p->date)->format('Y-m-d'),
                'due' => optional($p->due)->format('Y-m-d'),
                'status' => $p->status,
                'amount' => (float) $p->amount,
            ])
            ->values()
            ->toArray();

        $user = Auth::user();

        if ($request->ajax()) {
            return view(
                'payables.index',
                compact('user', 'company', 'payables')
            )->render();
        }

        return view(
            'payables.index',
            compact('user', 'company', 'payables')
        );
    }

    /**
     * Form tambah tagihan.
     */
    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        $vendors = $this->vendors;

        $lastNumber = Payable::where('company_id', $company->id)->count() + 1;

        $billNumber = 'B-' .
            now()->format('Y') .
            '-' .
            str_pad($lastNumber, 4, '0', STR_PAD_LEFT);

        return view(
            'payables.create',
            compact('user', 'company', 'vendors', 'billNumber')
        );
    }

    /**
     * Simpan tagihan baru.
     */
    public function store(Request $request)
    {
        $company = auth()->user()->company;

        abort_if(
            ! $company,
            403,
            'Lengkapi setup perusahaan terlebih dahulu.'
        );

        $data = $request->validate([
            'vendor_id' => 'required|integer',
            'number' => 'required|string|max:100',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'category' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.price' => 'nullable|numeric',
            'status' => 'nullable|string|in:draft,sent,paid',
        ]);

        $subtotal = 0;

        foreach ($data['items'] ?? [] as $item) {
            $subtotal +=
                ($item['quantity'] ?? 0) *
                ($item['price'] ?? 0);
        }

        $statusMapping = [
            'draft' => Payable::STATUS_LANCAR,
            'sent' => Payable::STATUS_LANCAR,
            'paid' => Payable::STATUS_LUNAS,
        ];

        $payable = Payable::create([
            'company_id' => $company->id,
            'vendor' => $this->vendors[$data['vendor_id']]
                ?? 'Vendor Tidak Dikenal',
            'bill_number' => $data['number'],
            'date' => $data['date'],
            'due' => $data['due_date'],
            'category' => $data['category'] ?? null,
            'status' => $statusMapping[$data['status'] ?? 'draft']
                ?? Payable::STATUS_LANCAR,
            'amount' => $subtotal,
            'items' => $data['items'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $this->logActivity(
            'created',
            'Membuat tagihan: ' .
                $payable->bill_number .
                ' - ' .
                $payable->vendor,
            $payable
        );

        // Akui tagihan sebagai kewajiban (accrual).
        $this->syncAccrualJournal(
            $company,
            $payable
        );

        // Kalau langsung dibuat berstatus lunas,
        // catat juga pembayarannya.
        if ($payable->status === Payable::STATUS_LUNAS) {
            $this->syncPaymentJournal(
                $company,
                $payable
            );
        }

        return redirect()
            ->route('payables.index')
            ->with(
                'success',
                'Tagihan berhasil dibuat!'
            );
    }

    /**
     * Detail tagihan.
     */
    public function show(Payable $payable)
    {
        $this->authorizeCompany($payable);

        $user = Auth::user();
        $company = $user->company;
        $index = $payable->id;
        $payableData = $this->toArray($payable);

        return view(
            'payables.show',
            [
                'user' => $user,
                'company' => $company,
                'payable' => $payableData,
                'index' => $index,
            ]
        );
    }

    /**
     * Form edit tagihan.
     */
    public function edit(Payable $payable)
    {
        $this->authorizeCompany($payable);

        $user = Auth::user();
        $company = $user->company;
        $index = $payable->id;
        $payableData = $this->toArray($payable);

        return view(
            'payables.edit',
            [
                'user' => $user,
                'company' => $company,
                'payable' => $payableData,
                'index' => $index,
            ]
        );
    }

    /**
     * Update tagihan.
     */
    public function update(
        Request $request,
        Payable $payable
    ) {
        $this->authorizeCompany($payable);

        $company = $payable->company;

        $data = $request->validate([
            'vendor' => 'nullable|string|max:255',
            'bill' => 'nullable|string|max:100',
            'date' => 'nullable|date',
            'due' => 'nullable|date',
            'status' => 'nullable|string|in:lancar,jatuh_tempo,lunas',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $wasLunas =
            $payable->status === Payable::STATUS_LUNAS;

        $payable->update([
            'vendor' => $data['vendor']
                ?? $payable->vendor,

            'bill_number' => $data['bill']
                ?? $payable->bill_number,

            'date' => $data['date']
                ?? $payable->date,

            'due' => $data['due']
                ?? $payable->due,

            'status' => $data['status']
                ?? $payable->status,

            'amount' => $data['amount']
                ?? $payable->amount,
        ]);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $this->logActivity(
            'updated',
            'Mengupdate tagihan: ' .
                $payable->bill_number .
                ' - ' .
                $payable->vendor,
            $payable
        );

        $this->syncAccrualJournal(
            $company,
            $payable
        );

        $isLunasNow =
            $payable->status === Payable::STATUS_LUNAS;

        if ($isLunasNow) {
            $this->syncPaymentJournal(
                $company,
                $payable
            );
        } elseif ($wasLunas && ! $isLunasNow) {
            // Status ditarik lagi dari Lunas,
            // hapus entry pembayaran yang lama.
            $this->deletePaymentJournal($payable);
        }

        return redirect()
            ->route('payables.index')
            ->with(
                'success',
                'Tagihan berhasil diperbarui!'
            );
    }

    /**
     * Hapus tagihan.
     */
    public function destroy(Payable $payable)
    {
        $this->authorizeCompany($payable);

        /*
         * Simpan data yang diperlukan untuk log
         * sebelum record dihapus.
         */
        $billNumber = $payable->bill_number;
        $vendor = $payable->vendor;

        // Hapus journal accrual.
        JournalEntry::where(
            'reference_type',
            'payable_accrual'
        )
            ->where(
                'reference_id',
                $payable->id
            )
            ->delete();

        // Hapus journal pembayaran.
        JournalEntry::where(
            'reference_type',
            'payable_payment'
        )
            ->where(
                'reference_id',
                $payable->id
            )
            ->delete();

        /*
         * CATAT RIWAYAT AKTIVITAS
         * sebelum Payable dihapus.
         */
        $this->logActivity(
            'deleted',
            'Menghapus tagihan: ' .
                $billNumber .
                ' - ' .
                $vendor,
            $payable
        );

        $payable->delete();

        return redirect()
            ->route('payables.index')
            ->with(
                'success',
                'Tagihan berhasil dihapus!'
            );
    }

    /**
     * Pastikan payable milik company user yang sedang login.
     */
    private function authorizeCompany(
        Payable $payable
    ): void {
        abort_unless(
            $payable->company_id ===
                auth()->user()->company_id,
            403
        );
    }

    /**
     * Konversi Payable ke array untuk view.
     */
    private function toArray(
        Payable $p
    ): array {
        return [
            'id' => $p->id,
            'vendor' => $p->vendor,
            'bill' => $p->bill_number,
            'date' => optional($p->date)
                ->format('Y-m-d'),
            'due' => optional($p->due)
                ->format('Y-m-d'),
            'status' => $p->status,
            'amount' => (float) $p->amount,
            'notes' => $p->notes,
            'items' => $p->items,
        ];
    }

    /**
     * Akui tagihan sebagai beban/aset + kewajiban (accrual):
     * debit akun sesuai kategori, kredit Utang Usaha (2-101).
     */
    private function syncAccrualJournal(
        $company,
        Payable $payable
    ): void {
        $expenseCode =
            $this->categoryToExpenseCode[
                strtolower(
                    $payable->category ?? ''
                )
            ] ?? '5-101';

        $expenseAccountId =
            ChartOfAccount::where(
                'company_id',
                $company->id
            )
                ->where(
                    'code',
                    $expenseCode
                )
                ->value('id');

        $payableAccountId =
            ChartOfAccount::where(
                'company_id',
                $company->id
            )
                ->where(
                    'code',
                    '2-101'
                )
                ->value('id');

        if (
            ! $expenseAccountId ||
            ! $payableAccountId
        ) {
            Log::warning(
                "Akun ({$expenseCode}) atau Utang Usaha (2-101) " .
                "tidak ditemukan untuk company #{$company->id}."
            );

            return;
        }

        $existing = JournalEntry::where(
            'reference_type',
            'payable_accrual'
        )
            ->where(
                'reference_id',
                $payable->id
            )
            ->get();

        $debitEntry = $existing->first(
            fn ($e) => (float) $e->debit > 0
        );

        $creditEntry = $existing->first(
            fn ($e) => (float) $e->credit > 0
        );

        $description =
            'Tagihan ' .
            $payable->bill_number .
            ' - ' .
            $payable->vendor;

        $payloadDebit = [
            'company_id' => $company->id,
            'chart_of_account_id' => $expenseAccountId,
            'transaction_date' => $payable->date,
            'description' => $description,
            'debit' => $payable->amount,
            'credit' => 0,
            'reference_type' => 'payable_accrual',
            'reference_id' => $payable->id,
        ];

        $payloadCredit = [
            'company_id' => $company->id,
            'chart_of_account_id' => $payableAccountId,
            'transaction_date' => $payable->date,
            'description' => $description,
            'debit' => 0,
            'credit' => $payable->amount,
            'reference_type' => 'payable_accrual',
            'reference_id' => $payable->id,
        ];

        $debitEntry
            ? $debitEntry->update($payloadDebit)
            : JournalEntry::create($payloadDebit);

        $creditEntry
            ? $creditEntry->update($payloadCredit)
            : JournalEntry::create($payloadCredit);
    }

    /**
     * Catat pelunasan:
     * debit Utang Usaha (2-101),
     * kredit Kas (1-102).
     */
    private function syncPaymentJournal(
        $company,
        Payable $payable
    ): void {
        $payableAccountId =
            ChartOfAccount::where(
                'company_id',
                $company->id
            )
                ->where(
                    'code',
                    '2-101'
                )
                ->value('id');

        $cashAccountId =
            ChartOfAccount::where(
                'company_id',
                $company->id
            )
                ->where(
                    'code',
                    '1-102'
                )
                ->value('id');

        if (
            ! $payableAccountId ||
            ! $cashAccountId
        ) {
            Log::warning(
                "Akun Utang Usaha (2-101) atau Kas (1-102) " .
                "tidak ditemukan untuk company #{$company->id}."
            );

            return;
        }

        $existing = JournalEntry::where(
            'reference_type',
            'payable_payment'
        )
            ->where(
                'reference_id',
                $payable->id
            )
            ->get();

        $debitEntry = $existing->first(
            fn ($e) => (float) $e->debit > 0
        );

        $creditEntry = $existing->first(
            fn ($e) => (float) $e->credit > 0
        );

        $description =
            'Pelunasan ' .
            $payable->bill_number .
            ' - ' .
            $payable->vendor;

        $payloadDebit = [
            'company_id' => $company->id,
            'chart_of_account_id' => $payableAccountId,
            'transaction_date' => now()->format('Y-m-d'),
            'description' => $description,
            'debit' => $payable->amount,
            'credit' => 0,
            'reference_type' => 'payable_payment',
            'reference_id' => $payable->id,
        ];

        $payloadCredit = [
            'company_id' => $company->id,
            'chart_of_account_id' => $cashAccountId,
            'transaction_date' => now()->format('Y-m-d'),
            'description' => $description,
            'debit' => 0,
            'credit' => $payable->amount,
            'reference_type' => 'payable_payment',
            'reference_id' => $payable->id,
        ];

        $debitEntry
            ? $debitEntry->update($payloadDebit)
            : JournalEntry::create($payloadDebit);

        $creditEntry
            ? $creditEntry->update($payloadCredit)
            : JournalEntry::create($payloadCredit);
    }

    /**
     * Hapus journal pembayaran.
     */
    private function deletePaymentJournal(
        Payable $payable
    ): void {
        JournalEntry::where(
            'reference_type',
            'payable_payment'
        )
            ->where(
                'reference_id',
                $payable->id
            )
            ->delete();
    }

    /**
     * Logging aktivitas.
     *
     * Method ini berasal dari trait LogsActivity.
     */
    protected function logActivity(
        string $action,
        string $description,
        $subject = null
    ): void {
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject
                ? get_class($subject)
                : null,
            'subject_id' => $subject->id ?? null,
            'ip_address' => request()->ip(),
        ]);
    }
}