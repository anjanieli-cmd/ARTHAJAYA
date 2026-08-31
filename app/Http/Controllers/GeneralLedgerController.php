<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class GeneralLedgerController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $accounts = ChartOfAccount::where('company_id', $company->id)
            ->orderBy('code')
            ->get()
            ->map(function ($account) {
                $totalDebit = JournalEntry::where('chart_of_account_id', $account->id)->sum('debit');
                $totalCredit = JournalEntry::where('chart_of_account_id', $account->id)->sum('credit');

                // Saldo dihitung sesuai arah normal akun
                $balance = $account->normal_balance === 'debit'
                    ? $totalDebit - $totalCredit
                    : $totalCredit - $totalDebit;

                $account->total_debit = $totalDebit;
                $account->total_credit = $totalCredit;
                $account->balance = $balance;

                return $account;
            });

        return view('ledger.index', compact('user', 'company', 'accounts'));
    }

    /**
     * Detail rincian transaksi untuk 1 akun tertentu.
     */
    public function show(Request $request, ChartOfAccount $account)
    {
        $user = $request->user();
        abort_unless($account->company_id === $user->company_id, 403);

        $entries = JournalEntry::where('chart_of_account_id', $account->id)
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        $runningBalance = 0;
        $entries = $entries->map(function ($entry) use ($account, &$runningBalance) {
            $runningBalance += $account->normal_balance === 'debit'
                ? $entry->debit - $entry->credit
                : $entry->credit - $entry->debit;

            $entry->running_balance = $runningBalance;
            return $entry;
        });

        return view('ledger.show', compact('user', 'account', 'entries'));
    }
}