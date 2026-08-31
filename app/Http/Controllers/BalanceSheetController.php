<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
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

                $account->balance = $account->normal_balance === 'debit'
                    ? $totalDebit - $totalCredit
                    : $totalCredit - $totalDebit;

                return $account;
            });

        $assets = $accounts->where('type', 'asset');
        $liabilities = $accounts->where('type', 'liability');
        $equity = $accounts->where('type', 'equity');

        // Laba/rugi berjalan (revenue - expense) otomatis masuk ke Modal
        $revenue = $accounts->where('type', 'revenue')->sum('balance');
        $expense = $accounts->where('type', 'expense')->sum('balance');
        $netIncome = $revenue - $expense;

        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance') + $netIncome;

        return view('neraca.index', compact(
            'user', 'company',
            'assets', 'liabilities', 'equity',
            'netIncome', 'totalAssets', 'totalLiabilities', 'totalEquity'
        ));
    }
}