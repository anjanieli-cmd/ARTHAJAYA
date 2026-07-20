<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $company = Auth::user()->company;
        $companyId = $company->id;

        $items = InventoryItem::where('company_id', $companyId)
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $allItems = InventoryItem::where('company_id', $companyId)->get();

        $stats = [
            'total_sku'   => $allItems->count(),
            'total_value' => $allItems->sum(fn ($i) => $i->stock_quantity * $i->cost_price),
            'low_stock'   => $allItems->filter(fn ($i) => $i->is_low_stock)->count(),
        ];

        $categories = InventoryItem::where('company_id', $companyId)
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('inventory.index', compact('items', 'stats', 'company', 'categories'));
    }

    public function show(InventoryItem $item)
    {
        $company = Auth::user()->company;

        return view('inventory.show', compact('item', 'company'));
    }

    public function create()
    {
        $company = Auth::user()->company;

        return view('inventory.create', compact('company'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['company_id'] = Auth::user()->company->id;

        InventoryItem::create($data);

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(InventoryItem $item)
    {
        $company = Auth::user()->company;

        return view('inventory.edit', compact('item', 'company'));
    }

    public function update(Request $request, InventoryItem $item)
    {
        $data = $this->validateData($request);

        $item->update($data);

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'sku'            => ['required', 'string', 'max:50'],
            'name'           => ['required', 'string', 'max:255'],
            'category'       => ['nullable', 'string', 'max:100'],
            'unit'           => ['required', 'string', 'max:20'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'reorder_level'  => ['required', 'integer', 'min:0'],
            'cost_price'     => ['required', 'numeric', 'min:0'],
            'selling_price'  => ['required', 'numeric', 'min:0'],
            'description'    => ['nullable', 'string'],
        ]);
    }
}