<?php

namespace App\Http\Controllers;

use App\Models\BankMutation;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankMutationController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = BankMutation::where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->whereRaw('LOWER(description) LIKE ?', ["%{$q}%"]);
        }

        $mutations = $query->get();

        if ($request->ajax()) {
            return view('bank-mutations.index', compact('user', 'company', 'mutations'))->render();
        }

        return view('bank-mutations.index', compact('user', 'company', 'mutations'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('bank-mutations.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'account_id'  => 'nullable|integer',
            'description' => 'required|string|max:255',
            'date'        => 'required|date',
            'amount'      => 'required|numeric',
            'balance'     => 'required|numeric',
            'category'    => 'nullable|string',
            'notes'       => 'nullable|string',
            'type'        => 'required|in:masuk,keluar',
        ]);

        $mutation = BankMutation::create([
            'company_id'  => $company->id,
            'account_id'  => $data['account_id'] ?? null,
            'description' => $data['description'],
            'date'        => $data['date'],
            'type'        => $data['type'],
            'amount'      => (int) $data['amount'],
            'balance'     => (int) $data['balance'],
            'category'    => $data['category'] ?? null,
            'notes'       => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Menambahkan mutasi bank: {$mutation->description}", $mutation);

        return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil ditambahkan!');
    }

    public function show(BankMutation $bankMutation)
    {
        $this->authorizeCompany($bankMutation);
        $user = Auth::user();
        $company = $user->company;
        $mutation = $bankMutation;
        return view('bank-mutations.show', compact('user', 'company', 'mutation'));
    }

    public function edit(BankMutation $bankMutation)
    {
        $this->authorizeCompany($bankMutation);
        $user = Auth::user();
        $company = $user->company;
        $mutation = $bankMutation;
        return view('bank-mutations.edit', compact('user', 'company', 'mutation'));
    }

    public function update(Request $request, BankMutation $bankMutation)
    {
        $this->authorizeCompany($bankMutation);

        $bankMutation->update($request->only([
            'description', 'date', 'type', 'amount', 'balance', 'category', 'notes',
        ]));

        $this->logActivity('updated', "Mengupdate mutasi bank: {$bankMutation->description}", $bankMutation);

        return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil diupdate!');
    }

    public function destroy(BankMutation $bankMutation)
    {
        $this->authorizeCompany($bankMutation);

        $desc = $bankMutation->description;
        $bankMutation->delete();

        $this->logActivity('deleted', "Menghapus mutasi bank: {$desc}");

        return redirect()->route('bank-mutations.index')->with('success', 'Mutasi berhasil dihapus!');
    }

    private function authorizeCompany(BankMutation $bankMutation): void
    {
        abort_unless($bankMutation->company_id === Auth::user()->company->id, 404);
    }
}