<?php

namespace App\Http\Controllers;

use App\Models\LabaRugiItem;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);

        $items = LabaRugiItem::period($month, $year)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $pendapatan = $items->where('type', 'pendapatan')->groupBy('category');
        $beban = $items->where('type', 'beban')->groupBy('category');

        $totalPendapatan = (float) $items->where('type', 'pendapatan')->sum('amount');
        $totalBeban = (float) $items->where('type', 'beban')->sum('amount');
        $labaBersih = $totalPendapatan - $totalBeban;

        return view('laba-rugi.index', compact(
            'pendapatan', 'beban', 'totalPendapatan', 'totalBeban', 'labaBersih', 'month', 'year'
        ));
    }

    public function create()
    {
        return view('laba-rugi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:pendapatan,beban',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string',
        ]);

        LabaRugiItem::create($validated);

        return redirect()
            ->route('laba-rugi.index', ['month' => $validated['period_month'], 'year' => $validated['period_year']])
            ->with('success', 'Pos laba rugi berhasil ditambahkan.');
    }

    public function show(LabaRugiItem $laba_rugi)
    {
        return view('laba-rugi.show', ['item' => $laba_rugi]);
    }

    public function edit(LabaRugiItem $laba_rugi)
    {
        return view('laba-rugi.edit', ['item' => $laba_rugi]);
    }

    public function update(Request $request, LabaRugiItem $laba_rugi)
    {
        $validated = $request->validate([
            'type' => 'required|in:pendapatan,beban',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string',
        ]);

        $laba_rugi->update($validated);

        return redirect()
            ->route('laba-rugi.index', ['month' => $validated['period_month'], 'year' => $validated['period_year']])
            ->with('success', 'Pos laba rugi berhasil diperbarui.');
    }

    public function destroy(LabaRugiItem $laba_rugi)
    {
        $month = $laba_rugi->period_month;
        $year = $laba_rugi->period_year;
        $laba_rugi->delete();

        return redirect()
            ->route('laba-rugi.index', ['month' => $month, 'year' => $year])
            ->with('success', 'Pos laba rugi berhasil dihapus.');
    }
}