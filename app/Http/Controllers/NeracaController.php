<?php

namespace App\Http\Controllers;

use App\Models\NeracaItem;
use Illuminate\Http\Request;

class NeracaController extends Controller
{
    public function index(Request $request)
    {
        $asOfDate = $request->get('as_of_date', now()->format('Y-m-d'));

        $items = NeracaItem::asOf($asOfDate)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $aset = $items->where('type', 'aset')->groupBy('category');
        $kewajiban = $items->where('type', 'kewajiban')->groupBy('category');
        $modal = $items->where('type', 'modal')->groupBy('category');

        $totalAset = (float) $items->where('type', 'aset')->sum('amount');
        $totalKewajiban = (float) $items->where('type', 'kewajiban')->sum('amount');
        $totalModal = (float) $items->where('type', 'modal')->sum('amount');
        $totalPasiva = $totalKewajiban + $totalModal;
        $isBalanced = abs($totalAset - $totalPasiva) < 0.01;

        return view('neraca.index', compact(
            'aset', 'kewajiban', 'modal',
            'totalAset', 'totalKewajiban', 'totalModal', 'totalPasiva', 'isBalanced', 'asOfDate'
        ));
    }

    public function create()
    {
        return view('neraca.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:aset,kewajiban,modal',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'as_of_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        NeracaItem::create($validated);

        return redirect()
            ->route('neraca.index', ['as_of_date' => $validated['as_of_date']])
            ->with('success', 'Pos neraca berhasil ditambahkan.');
    }

    public function show(NeracaItem $neraca)
    {
        return view('neraca.show', ['item' => $neraca]);
    }

    public function edit(NeracaItem $neraca)
    {
        return view('neraca.edit', ['item' => $neraca]);
    }

    public function update(Request $request, NeracaItem $neraca)
    {
        $validated = $request->validate([
            'type' => 'required|in:aset,kewajiban,modal',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            'as_of_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $neraca->update($validated);

        return redirect()
            ->route('neraca.index', ['as_of_date' => $validated['as_of_date']])
            ->with('success', 'Pos neraca berhasil diperbarui.');
    }

    public function destroy(NeracaItem $neraca)
    {
        $asOfDate = $neraca->as_of_date->format('Y-m-d');
        $neraca->delete();

        return redirect()
            ->route('neraca.index', ['as_of_date' => $asOfDate])
            ->with('success', 'Pos neraca berhasil dihapus.');
    }
}