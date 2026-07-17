<?php

namespace App\Http\Controllers;

use App\Models\LedgerEntry;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $accountCode = $request->get('account');
        $from = $request->get('from');
        $to = $request->get('to');

        $accounts = LedgerEntry::select('account_code', 'account_name')
            ->selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')
            ->groupBy('account_code', 'account_name')
            ->orderBy('account_code')
            ->get();

        $entries = collect();
        $runningBalance = 0;
        $selectedAccount = null;

        if ($accountCode) {
            $selectedAccount = $accounts->firstWhere('account_code', $accountCode);

            $entries = LedgerEntry::account($accountCode)
                ->when($from, fn($q) => $q->whereDate('transaction_date', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('transaction_date', '<=', $to))
                ->orderBy('transaction_date')
                ->orderBy('id')
                ->get()
                ->map(function ($entry) use (&$runningBalance) {
                    $runningBalance += (float) $entry->debit - (float) $entry->credit;
                    $entry->running_balance = $runningBalance;
                    return $entry;
                });
        }

        return view('ledger.index', compact('accounts', 'entries', 'accountCode', 'selectedAccount', 'from', 'to'));
    }

    public function create()
    {
        return view('ledger.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => 'required|string|max:30',
            'account_name' => 'required|string|max:150',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['debit'] = $validated['debit'] ?? 0;
        $validated['credit'] = $validated['credit'] ?? 0;

        LedgerEntry::create($validated);

        return redirect()
            ->route('ledger.index', ['account' => $validated['account_code']])
            ->with('success', 'Transaksi buku besar berhasil ditambahkan.');
    }

    public function edit(LedgerEntry $ledger)
    {
        return view('ledger.edit', ['item' => $ledger]);
    }

    public function update(Request $request, LedgerEntry $ledger)
    {
        $validated = $request->validate([
            'account_code' => 'required|string|max:30',
            'account_name' => 'required|string|max:150',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['debit'] = $validated['debit'] ?? 0;
        $validated['credit'] = $validated['credit'] ?? 0;

        $ledger->update($validated);

        return redirect()
            ->route('ledger.index', ['account' => $validated['account_code']])
            ->with('success', 'Transaksi buku besar berhasil diperbarui.');
    }

    public function destroy(LedgerEntry $ledger)
    {
        $accountCode = $ledger->account_code;
        $ledger->delete();

        return redirect()
            ->route('ledger.index', ['account' => $accountCode])
            ->with('success', 'Transaksi buku besar berhasil dihapus.');
    }
}