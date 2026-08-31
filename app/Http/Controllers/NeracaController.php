<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class NeracaController extends Controller
{
    /**
     * Neraca dihitung otomatis dari saldo akun (chart_of_accounts + journal_entries),
     * sampai dengan tanggal tertentu (as_of_date). Halaman ini READ-ONLY -
     * tidak ada input manual, karena datanya harus selalu konsisten dengan Buku Besar.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $asOfDate = $request->get('as_of_date', now()->format('Y-m-d'));

        $currencySymbols = ['IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM'];
        $currencySymbol  = $currencySymbols[$company->currency ?? 'IDR'] ?? 'Rp';

        $accounts = ChartOfAccount::where('company_id', $company->id)
            ->where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function ($account) use ($asOfDate) {
                $totalDebit = JournalEntry::where('chart_of_account_id', $account->id)
                    ->whereDate('transaction_date', '<=', $asOfDate)
                    ->sum('debit');

                $totalCredit = JournalEntry::where('chart_of_account_id', $account->id)
                    ->whereDate('transaction_date', '<=', $asOfDate)
                    ->sum('credit');

                $account->amount = $account->normal_balance === 'debit'
                    ? $totalDebit - $totalCredit
                    : $totalCredit - $totalDebit;

                return $account;
            })
            ->filter(fn ($account) => $account->amount != 0); // sembunyikan akun yang saldonya nol

        // Kelompokkan sesuai label yang dipakai view (aset/kewajiban/modal)
        $aset = $accounts->where('type', 'asset')
            ->groupBy(fn () => 'Aset');

        $kewajiban = $accounts->where('type', 'liability')
            ->groupBy(fn () => 'Kewajiban');

        $modalAccounts = $accounts->where('type', 'equity');

        // Laba/rugi berjalan (pendapatan - biaya) otomatis ditambahkan ke Modal,
        // supaya Neraca tetap seimbang (Aset = Kewajiban + Modal)
        $totalRevenue = $accounts->where('type', 'revenue')->sum('amount');
        $totalExpense = $accounts->where('type', 'expense')->sum('amount');
        $netIncome = $totalRevenue - $totalExpense;

        // Tambahkan sebagai baris "semu" di kelompok Modal, biar tampil di tabel
        // tanpa perlu mengubah struktur view
        $netIncomeRow = new \stdClass();
        $netIncomeRow->id = null;
        $netIncomeRow->name = 'Laba/Rugi Berjalan';
        $netIncomeRow->amount = $netIncome;
        $modalAccounts = $netIncome != 0 ? $modalAccounts->push($netIncomeRow) : $modalAccounts;

        $modal = $modalAccounts->groupBy(fn () => 'Modal');

        $totalAset = (float) $aset->flatten()->sum('amount');
        $totalKewajiban = (float) $kewajiban->flatten()->sum('amount');
        $totalModal = (float) $modalAccounts->sum('amount') + $netIncome;
        $totalPasiva = $totalKewajiban + $totalModal;
        $isBalanced = abs($totalAset - $totalPasiva) < 0.01;

        return view('neraca.index', compact(
            'company', 'currencySymbol',
            'aset', 'kewajiban', 'modal',
            'totalAset', 'totalKewajiban', 'totalModal', 'totalPasiva',
            'netIncome', 'isBalanced', 'asOfDate'
        ));
    }
}