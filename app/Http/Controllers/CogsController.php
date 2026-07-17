<?php

namespace App\Http\Controllers;

use App\Models\CogsEntry;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CogsController extends Controller
{
    public function index(Request $request)
    {
        $company = Auth::user()->company;
        $companyId = $company->id;

        $query = CogsEntry::where('company_id', $companyId)->with('inventoryItem');

        if ($request->filled('q')) {
            $query->where('item_name', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('month')) {
            // format input month: YYYY-MM
            $query->whereYear('sale_date', substr($request->month, 0, 4))
                  ->whereMonth('sale_date', substr($request->month, 5, 2));
        }

        $entries = $query->orderByDesc('sale_date')->orderByDesc('id')->paginate(10)->withQueryString();

        $thisMonth = CogsEntry::where('company_id', $companyId)
            ->whereYear('sale_date', now()->year)
            ->whereMonth('sale_date', now()->month);

        $stats = [
            'total_cogs_month' => (clone $thisMonth)->sum('total_cogs'),
            'total_qty_month'  => (clone $thisMonth)->sum('quantity_sold'),
            'avg_unit_cost'    => (clone $thisMonth)->avg('unit_cost') ?? 0,
        ];

        // kelompokkan entri berdasarkan tanggal untuk tampilan timeline
        $groupedEntries = $entries->getCollection()->groupBy(fn ($e) => $e->sale_date->format('Y-m-d'));

        return view('cogs.index', compact('entries', 'groupedEntries', 'stats', 'company'));
    }

    public function create()
    {
        $company = Auth::user()->company;
        $items = InventoryItem::where('company_id', $company->id)->orderBy('name')->get();

        return view('cogs.create', compact('items', 'company'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['company_id'] = Auth::user()->company->id;

        if (!empty($data['inventory_item_id'])) {
            $invItem = InventoryItem::find($data['inventory_item_id']);
            if ($invItem) {
                $data['item_name'] = $invItem->name;
                $invItem->decrement('stock_quantity', $data['quantity_sold']);
            }
        }

        CogsEntry::create($data);

        return redirect()->route('cogs.index')->with('success', 'Catatan HPP berhasil ditambahkan.');
    }

    public function edit(CogsEntry $entry)
    {
        $company = Auth::user()->company;
        $items = InventoryItem::where('company_id', $company->id)->orderBy('name')->get();

        return view('cogs.edit', compact('entry', 'items', 'company'));
    }

    public function update(Request $request, CogsEntry $entry)
    {
        $data = $this->validateData($request);

        // sesuaikan stok kalau qty berubah dan masih terhubung ke barang yang sama
        if ($entry->inventory_item_id && $entry->inventoryItem
            && (int) ($data['inventory_item_id'] ?? 0) === $entry->inventory_item_id) {
            $diff = $data['quantity_sold'] - $entry->quantity_sold;
            if ($diff !== 0) {
                $entry->inventoryItem->decrement('stock_quantity', $diff);
            }
        }

        if (!empty($data['inventory_item_id'])) {
            $invItem = InventoryItem::find($data['inventory_item_id']);
            if ($invItem) {
                $data['item_name'] = $invItem->name;
            }
        }

        $entry->update($data);

        return redirect()->route('cogs.index')->with('success', 'Catatan HPP berhasil diperbarui.');
    }

    public function destroy(CogsEntry $entry)
    {
        if ($entry->inventory_item_id && $entry->inventoryItem) {
            $entry->inventoryItem->increment('stock_quantity', $entry->quantity_sold);
        }

        $entry->delete();

        return redirect()->route('cogs.index')->with('success', 'Catatan HPP berhasil dihapus.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'inventory_item_id' => ['nullable', 'exists:inventory_items,id'],
            'item_name'         => ['required_without:inventory_item_id', 'nullable', 'string', 'max:255'],
            'quantity_sold'     => ['required', 'integer', 'min:1'],
            'unit_cost'         => ['required', 'numeric', 'min:0'],
            'sale_date'         => ['required', 'date'],
            'notes'             => ['nullable', 'string'],
        ]);
    }
}