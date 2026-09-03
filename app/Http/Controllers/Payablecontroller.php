<?php

namespace App\Http\Controllers;

use App\Models\Payable;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayableController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Payable::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(vendor) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(bill_number) LIKE ?', ["%{$q}%"]);
            });
        }

        $payables = $query->get();

        if ($request->ajax()) {
            return view('payables.index', compact('user', 'company', 'payables'))->render();
        }

        return view('payables.index', compact('user', 'company', 'payables'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('payables.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'vendor'      => 'required|string|max:255',
            'number'      => 'nullable|string|max:100',
            'date'        => 'required|date',
            'due_date'    => 'required|date',
            'category'    => 'nullable|string',
            'notes'       => 'nullable|string',
            'status'      => 'nullable|string',
            'items'       => 'nullable|array',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.price'    => 'nullable|numeric',
        ]);

        $subtotal = 0;
        foreach ($request->input('items', []) as $item) {
            $subtotal += ($item['quantity'] ?? 0) * ($item['price'] ?? 0);
        }

        $statusMapping = ['draft' => 'lancar', 'sent' => 'lancar', 'paid' => 'lunas'];

        $payable = Payable::create([
            'company_id'  => $company->id,
            'vendor'      => $data['vendor'],
            'bill_number' => $data['number'] ?? null,
            'date'        => $data['date'],
            'due_date'    => $data['due_date'],
            'category'    => $data['category'] ?? null,
            'notes'       => $data['notes'] ?? null,
            'status'      => $statusMapping[$data['status'] ?? ''] ?? 'lancar',
            'amount'      => $subtotal,
        ]);

        $this->logActivity('created', "Membuat tagihan untuk vendor {$payable->vendor}", $payable);

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil dibuat!');
    }

    public function show(Payable $payable)
    {
        $this->authorizeCompany($payable);
        $user = Auth::user();
        $company = $user->company;
        return view('payables.show', compact('user', 'company', 'payable'));
    }

    public function edit(Payable $payable)
    {
        $this->authorizeCompany($payable);
        $user = Auth::user();
        $company = $user->company;
        return view('payables.edit', compact('user', 'company', 'payable'));
    }

    public function update(Request $request, Payable $payable)
    {
        $this->authorizeCompany($payable);

        $payable->update($request->only([
            'vendor', 'bill_number', 'date', 'due_date', 'category', 'notes', 'status', 'amount',
        ]));

        $this->logActivity('updated', "Mengupdate tagihan vendor {$payable->vendor}", $payable);

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil diupdate!');
    }

    public function destroy(Payable $payable)
    {
        $this->authorizeCompany($payable);

        $vendor = $payable->vendor;
        $payable->delete();

        $this->logActivity('deleted', "Menghapus tagihan vendor {$vendor}");

        return redirect()->route('payables.index')->with('success', 'Tagihan berhasil dihapus!');
    }

    private function authorizeCompany(Payable $payable): void
    {
        abort_unless($payable->company_id === Auth::user()->company->id, 404);
    }
}