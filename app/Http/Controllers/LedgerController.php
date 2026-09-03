<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $companyId = $user->company_id;

        $accountCode = $request->get('account');
        $from = $request->get('from');
        $to = $request->get('to');

        // Daftar akun + total debit/credit tiap akun,
        // HANYA milik company yang login
        $accounts = ChartOfAccount::where('company_id', $companyId)
            ->orderBy('code')
            ->get()
            ->map(function ($acc) {
                $acc->account_code = $acc->code;
                $acc->account_name = $acc->name;
                $acc->total_debit = JournalEntry::where(
                    'chart_of_account_id',
                    $acc->id
                )->sum('debit');

                $acc->total_credit = JournalEntry::where(
                    'chart_of_account_id',
                    $acc->id
                )->sum('credit');

                return $acc;
            });

        // Statistik keseluruhan
        $totalEntries = JournalEntry::where(
            'company_id',
            $companyId
        )->count();

        $totalDebit = JournalEntry::where(
            'company_id',
            $companyId
        )->sum('debit');

        $totalCredit = JournalEntry::where(
            'company_id',
            $companyId
        )->sum('credit');

        $entries = collect();
        $selectedAccount = null;

        if ($accountCode) {
            $selectedAccount = $accounts->firstWhere(
                'account_code',
                $accountCode
            );

            if ($selectedAccount) {
                $runningBalance = 0;

                $query = JournalEntry::where(
                    'chart_of_account_id',
                    $selectedAccount->id
                )
                    ->when(
                        $from,
                        fn ($q) => $q->whereDate(
                            'transaction_date',
                            '>=',
                            $from
                        )
                    )
                    ->when(
                        $to,
                        fn ($q) => $q->whereDate(
                            'transaction_date',
                            '<=',
                            $to
                        )
                    )
                    ->orderBy('transaction_date')
                    ->orderBy('id');

                $entries = $query
                    ->paginate(15)
                    ->withQueryString();

                // Hitung saldo berjalan
                $normalBalance = $selectedAccount->normal_balance;

                $entries->getCollection()->transform(
                    function ($entry) use (
                        &$runningBalance,
                        $normalBalance
                    ) {
                        $runningBalance +=
                            $normalBalance === 'debit'
                                ? $entry->debit - $entry->credit
                                : $entry->credit - $entry->debit;

                        $entry->running_balance = $runningBalance;
                        $entry->account_code =
                            $entry->account->code ?? null;
                        $entry->account_name =
                            $entry->account->name ?? null;

                        return $entry;
                    }
                );
            }
        }

        return view(
            'ledger.index',
            compact(
                'accounts',
                'entries',
                'accountCode',
                'selectedAccount',
                'from',
                'to',
                'totalEntries',
                'totalDebit',
                'totalCredit'
            )
        );
    }

    public function create()
    {
        $user = auth()->user();

        $accounts = ChartOfAccount::where(
            'company_id',
            $user->company_id
        )
            ->orderBy('code')
            ->get();

        return view(
            'ledger.create',
            compact('accounts')
        );
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'chart_of_account_id' => 'required|exists:chart_of_accounts,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $account = ChartOfAccount::findOrFail(
            $validated['chart_of_account_id']
        );

        abort_unless(
            $account->company_id === $user->company_id,
            403
        );

        $entry = JournalEntry::create([
            'company_id' => $user->company_id,
            'chart_of_account_id' => $account->id,
            'transaction_date' => $validated['transaction_date'],
            'description' => $validated['description'],
            'debit' => $validated['debit'] ?? 0,
            'credit' => $validated['credit'] ?? 0,
            'notes' => $validated['notes'] ?? null,
        ]);

        // CATAT RIWAYAT AKTIVITAS
        $this->logActivity(
            'created',
            'Menambahkan transaksi buku besar: ' .
                $entry->description .
                ' pada akun ' .
                $account->code .
                ' - ' .
                $account->name,
            $entry
        );

        return redirect()
            ->route(
                'ledger.index',
                ['account' => $account->code]
            )
            ->with(
                'success',
                'Transaksi buku besar berhasil ditambahkan.'
            );
    }

    public function show(
        Request $request,
        JournalEntry $ledger
    ) {
        abort_unless(
            $ledger->company_id ===
                $request->user()->company_id,
            403
        );

        $ledger->account_code =
            $ledger->account->code ?? null;

        $ledger->account_name =
            $ledger->account->name ?? null;

        return view(
            'ledger.show',
            ['item' => $ledger]
        );
    }

    public function edit(
        Request $request,
        JournalEntry $ledger
    ) {
        abort_unless(
            $ledger->company_id ===
                $request->user()->company_id,
            403
        );

        $ledger->account_name =
            $ledger->account->name ?? null;

        $ledger->account_code =
            $ledger->account->code ?? null;

        $accounts = ChartOfAccount::where(
            'company_id',
            $request->user()->company_id
        )
            ->orderBy('code')
            ->get();

        return view(
            'ledger.edit',
            [
                'item' => $ledger,
                'accounts' => $accounts,
            ]
        );
    }

    public function update(
        Request $request,
        JournalEntry $ledger
    ) {
        abort_unless(
            $ledger->company_id ===
                $request->user()->company_id,
            403
        );

        $validated = $request->validate([
            'chart_of_account_id' => 'required|exists:chart_of_accounts,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $account = ChartOfAccount::findOrFail(
            $validated['chart_of_account_id']
        );

        abort_unless(
            $account->company_id ===
                $request->user()->company_id,
            403
        );

        $validated['debit'] =
            $validated['debit'] ?? 0;

        $validated['credit'] =
            $validated['credit'] ?? 0;

        $oldDescription = $ledger->description;

        $ledger->update($validated);

        // CATAT RIWAYAT AKTIVITAS
        $this->logActivity(
            'updated',
            'Mengupdate transaksi buku besar: ' .
                $oldDescription .
                ' menjadi ' .
                $ledger->description .
                ' pada akun ' .
                $account->code .
                ' - ' .
                $account->name,
            $ledger
        );

        return redirect()
            ->route(
                'ledger.index',
                ['account' => $account->code]
            )
            ->with(
                'success',
                'Transaksi buku besar berhasil diperbarui.'
            );
    }

    public function destroy(
        Request $request,
        JournalEntry $ledger
    ) {
        abort_unless(
            $ledger->company_id ===
                $request->user()->company_id,
            403
        );

        $accountCode =
            $ledger->account->code ?? null;

        $description =
            $ledger->description;

        $accountName =
            $ledger->account->name ?? '';

        // CATAT RIWAYAT SEBELUM DATA DIHAPUS
        $this->logActivity(
            'deleted',
            'Menghapus transaksi buku besar: ' .
                $description .
                ' pada akun ' .
                $accountCode .
                ' - ' .
                $accountName,
            $ledger
        );

        $ledger->delete();

        return redirect()
            ->route(
                'ledger.index',
                ['account' => $accountCode]
            )
            ->with(
                'success',
                'Transaksi buku besar berhasil dihapus.'
            );
    }

    /**
     * Mencatat aktivitas ke tabel activity_logs.
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