<?php

namespace App\Http\Controllers;

use App\Models\TaxPph;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Services\JournalService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaxPphController extends Controller
{
    use LogsActivity;

    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $query = TaxPph::where('company_id', $company->id)
            ->orderByDesc('id');

        if ($q = $request->get('q')) {
            $q = strtolower(trim($q));

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(period) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('CAST(tax AS CHAR) LIKE ?', ["%{$q}%"]);
            });
        }

        $pphData = $query->get()
            ->map(function ($item) {
                return [
                    '_index'    => $item->id,
                    'period'    => $item->period,
                    'gross'     => (int) $item->gross,
                    'deduction' => (int) $item->deduction,
                    'taxable'   => (int) $item->taxable,
                    'tax'       => (int) $item->tax,
                    'status'    => $item->status,
                    'due'       => $item->due
                        ? $item->due->format('Y-m-d')
                        : null,
                    'notes'     => $item->notes,
                ];
            })
            ->toArray();

        $currencySymbols = [
            'IDR' => 'Rp',
            'USD' => '$',
            'SGD' => 'S$',
            'MYR' => 'RM',
        ];

        $currencySymbol =
            $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        if ($request->ajax()) {
            return view(
                'taxes.pph',
                compact(
                    'user',
                    'company',
                    'pphData',
                    'currencySymbol'
                )
            )->render();
        }

        return view(
            'taxes.pph',
            compact(
                'user',
                'company',
                'pphData',
                'currencySymbol'
            )
        );
    }

    /**
     * =========================================================
     * CREATE
     * =========================================================
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view(
            'taxes.create_pph',
            compact('user', 'company')
        );
    }

    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'period' => [
                'required',
                'string',
                'max:100',
            ],

            'gross' => [
                'required',
                'numeric',
                'min:0',
            ],

            'deduction' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tax' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:pending,paid',
            ],

            'due' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $gross = (float) $validated['gross'];
        $deduction = (float) ($validated['deduction'] ?? 0);
        $tax = (float) $validated['tax'];

        /*
         * Jangan sampai pengurang lebih besar
         * daripada penghasilan bruto.
         */
        if ($deduction > $gross) {
            return back()
                ->withInput()
                ->withErrors([
                    'deduction' =>
                        'Pengurang/Potongan tidak boleh lebih besar dari Penghasilan Bruto.',
                ]);
        }

        $taxable = max(0, $gross - $deduction);

        try {
            DB::beginTransaction();

            /*
             * =================================================
             * SIMPAN DATA PPH
             * =================================================
             */
            $pph = TaxPph::create([
                'company_id' => $user->company_id,
                'period' => $validated['period'],
                'gross' => $gross,
                'deduction' => $deduction,
                'taxable' => $taxable,
                'tax' => $tax,
                'status' => $validated['status'],
                'due' => $validated['due'],
                'notes' => $validated['notes'] ?? null,
            ]);

            /*
             * =================================================
             * LOG AKTIVITAS
             * =================================================
             */
            $this->logActivity(
                'created',
                "Menambahkan PPh periode {$pph->period}",
                $pph
            );

            /*
             * =================================================
             * JURNAL PPH
             *
             * Debit  : Biaya Pajak
             * Credit : Utang Pajak
             *
             * JANGAN membuat proses penyimpanan PPh gagal
             * hanya karena akun jurnal belum tersedia.
             * =================================================
             */

            try {
                /*
                 * Pastikan akun memang tersedia.
                 *
                 * 5-101 = akun biaya
                 * 2-102 = akun utang pajak
                 */
                $debitAccountExists = ChartOfAccount::where(
                    'company_id',
                    $user->company_id
                )
                    ->where('code', '5-101')
                    ->exists();

                $creditAccountExists = ChartOfAccount::where(
                    'company_id',
                    $user->company_id
                )
                    ->where('code', '2-102')
                    ->exists();

                if ($debitAccountExists && $creditAccountExists && $tax > 0) {
                    JournalService::record(
                        companyId: $user->company_id,
                        debitAccountCode: '5-101',
                        creditAccountCode: '2-102',
                        amount: $tax,
                        description: 'PPh periode ' . $pph->period,
                        referenceType: TaxPph::class,
                        referenceId: $pph->id,
                        date: $validated['due'],
                    );
                } else {
                    Log::warning(
                        'Jurnal PPh tidak dibuat karena akun COA belum tersedia.',
                        [
                            'company_id' => $user->company_id,
                            'pph_id' => $pph->id,
                            'debit_account' => '5-101',
                            'credit_account' => '2-102',
                        ]
                    );
                }
            } catch (\Throwable $journalError) {

                /*
                 * Kalau jurnal gagal, data PPh tetap berhasil disimpan.
                 */
                Log::error(
                    'Gagal membuat jurnal PPh.',
                    [
                        'company_id' => $user->company_id,
                        'pph_id' => $pph->id,
                        'error' => $journalError->getMessage(),
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('taxes.pph')
                ->with(
                    'success',
                    'PPh berhasil ditambahkan!'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Gagal menyimpan PPh.',
                [
                    'company_id' => $user->company_id,
                    'error' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'PPh gagal disimpan. Silakan periksa data yang dimasukkan.'
                );
        }
    }

    /**
     * =========================================================
     * SHOW
     * =========================================================
     */
    public function show(Request $request, $index)
    {
        $user = $request->user();

        $pph = TaxPph::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        return view('taxes.show_pph', [
            'user' => $user,
            'company' => $user->company,

            'pph' => [
                '_index' => $pph->id,
                'period' => $pph->period,
                'gross' => (int) $pph->gross,
                'deduction' => (int) $pph->deduction,
                'taxable' => (int) $pph->taxable,
                'tax' => (int) $pph->tax,
                'status' => $pph->status,
                'due' => $pph->due
                    ? $pph->due->format('Y-m-d')
                    : null,
                'notes' => $pph->notes,
            ],

            'index' => $pph->id,
        ]);
    }

    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit(Request $request, $index)
    {
        $user = $request->user();

        $pph = TaxPph::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        return view('taxes.edit_pph', [
            'user' => $user,
            'company' => $user->company,

            'pph' => [
                '_index' => $pph->id,
                'period' => $pph->period,
                'gross' => (int) $pph->gross,
                'deduction' => (int) $pph->deduction,
                'taxable' => (int) $pph->taxable,
                'tax' => (int) $pph->tax,
                'status' => $pph->status,
                'due' => $pph->due
                    ? $pph->due->format('Y-m-d')
                    : null,
                'notes' => $pph->notes,
            ],

            'index' => $pph->id,
        ]);
    }

    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(Request $request, $index)
    {
        $user = $request->user();

        $pph = TaxPph::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        $validated = $request->validate([
            'period' => 'required|string|max:100',
            'gross' => 'required|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid',
            'due' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $gross = (float) $validated['gross'];
        $deduction = (float) ($validated['deduction'] ?? 0);

        if ($deduction > $gross) {
            return back()
                ->withInput()
                ->withErrors([
                    'deduction' =>
                        'Pengurang/Potongan tidak boleh lebih besar dari Penghasilan Bruto.',
                ]);
        }

        $pph->update([
            'period' => $validated['period'],
            'gross' => $gross,
            'deduction' => $deduction,
            'taxable' => max(0, $gross - $deduction),
            'tax' => (float) $validated['tax'],
            'status' => $validated['status'],
            'due' => $validated['due'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $this->logActivity(
            'updated',
            "Mengupdate PPh periode {$pph->period}",
            $pph
        );

        return redirect()
            ->route('taxes.pph')
            ->with(
                'success',
                'PPh berhasil diupdate!'
            );
    }

    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy(Request $request, $index)
    {
        $user = $request->user();

        $pph = TaxPph::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        $period = $pph->period;

        /*
         * Hapus jurnal yang berkaitan dengan PPh
         * terlebih dahulu supaya tidak meninggalkan
         * jurnal yatim.
         */
        JournalEntry::where(
            'company_id',
            $user->company_id
        )
            ->where('reference_type', TaxPph::class)
            ->where('reference_id', $pph->id)
            ->delete();

        $pph->delete();

        $this->logActivity(
            'deleted',
            "Menghapus data PPh periode {$period}"
        );

        return redirect()
            ->route('taxes.pph')
            ->with(
                'success',
                'Data PPh berhasil dihapus!'
            );
    }

    /**
     * =========================================================
     * PAY
     * =========================================================
     */
    public function pay(Request $request, $index)
    {
        $user = $request->user();

        $pph = TaxPph::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        if ($pph->status === 'paid') {
            return redirect()
                ->route('taxes.pph')
                ->with(
                    'error',
                    'PPh ini sudah dibayar sebelumnya!'
                );
        }

        try {
            DB::beginTransaction();

            $pph->update([
                'status' => 'paid',
            ]);

            $this->logActivity(
                'updated',
                "Membayar PPh periode {$pph->period}",
                $pph
            );

            /*
             * Pelunasan:
             *
             * Debit  : Utang Pajak
             * Credit : Kas
             *
             * Kode akun mengikuti pola COA project:
             *
             * 2-102 = Utang Pajak
             * 1-102 = Kas
             */
            try {
                $debitAccountExists = ChartOfAccount::where(
                    'company_id',
                    $user->company_id
                )
                    ->where('code', '2-102')
                    ->exists();

                $creditAccountExists = ChartOfAccount::where(
                    'company_id',
                    $user->company_id
                )
                    ->where('code', '1-102')
                    ->exists();

                if (
                    $debitAccountExists &&
                    $creditAccountExists &&
                    (float) $pph->tax > 0
                ) {
                    JournalService::record(
                        companyId: $user->company_id,
                        debitAccountCode: '2-102',
                        creditAccountCode: '1-102',
                        amount: (float) $pph->tax,
                        description: 'Pembayaran PPh periode ' . $pph->period,
                        referenceType: TaxPph::class,
                        referenceId: $pph->id,
                        date: now()->toDateString(),
                    );
                } else {
                    Log::warning(
                        'Jurnal pembayaran PPh tidak dibuat karena akun COA belum tersedia.',
                        [
                            'company_id' => $user->company_id,
                            'pph_id' => $pph->id,
                        ]
                    );
                }
            } catch (\Throwable $journalError) {

                Log::error(
                    'Gagal membuat jurnal pembayaran PPh.',
                    [
                        'company_id' => $user->company_id,
                        'pph_id' => $pph->id,
                        'error' => $journalError->getMessage(),
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('taxes.pph')
                ->with(
                    'success',
                    'PPh berhasil dibayar!'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Gagal membayar PPh.',
                [
                    'company_id' => $user->company_id,
                    'pph_id' => $pph->id,
                    'error' => $e->getMessage(),
                ]
            );

            return redirect()
                ->route('taxes.pph')
                ->with(
                    'error',
                    'PPh gagal dibayar.'
                );
        }
    }
}