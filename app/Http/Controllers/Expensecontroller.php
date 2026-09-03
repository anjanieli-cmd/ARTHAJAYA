<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Expense::with('category')->where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(description) LIKE ?', ["%{$q}%"])
                    ->orWhereHas('category', function ($c) use ($q) {
                        $c->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"]);
                    });
            });
        }

        $expenses = $query->get();

        if ($request->ajax()) {
            return view('expenses.index', compact('user', 'company', 'expenses'))->render();
        }

        return view('expenses.index', compact('user', 'company', 'expenses'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        $categories = ExpenseCategory::where('company_id', $company->id)->orderBy('name')->get();
        return view('expenses.create', compact('user', 'company', 'categories'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'description'        => 'required|string|max:255',
            'expense_category_id'=> 'nullable|exists:expense_categories,id',
            'date'                => 'required|date',
            'amount'              => 'required|numeric',
            'status'              => 'nullable|string',
            'notes'               => 'nullable|string',
        ]);

        $expense = Expense::create([
            'company_id'           => $company->id,
            'expense_category_id'  => $data['expense_category_id'] ?? null,
            'description'          => $data['description'],
            'date'                 => $data['date'],
            'amount'               => (int) $data['amount'],
            'status'               => $data['status'] ?? 'pending',
            'notes'                => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Mencatat pengeluaran: {$expense->description}", $expense);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function show(Expense $expense)
    {
        $this->authorizeCompany($expense);
        $user = Auth::user();
        $company = $user->company;
        return view('expenses.show', compact('user', 'company', 'expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorizeCompany($expense);
        $user = Auth::user();
        $company = $user->company;
        $categories = ExpenseCategory::where('company_id', $company->id)->orderBy('name')->get();
        return view('expenses.edit', compact('user', 'company', 'expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorizeCompany($expense);

        $expense->update($request->only([
            'description', 'expense_category_id', 'date', 'status', 'amount', 'notes',
        ]));

        $this->logActivity('updated', "Mengupdate pengeluaran: {$expense->description}", $expense);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy(Expense $expense)
    {
        $this->authorizeCompany($expense);

        $desc = $expense->description;
        $expense->delete();

        $this->logActivity('deleted', "Menghapus pengeluaran: {$desc}");

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }

    private function authorizeCompany(Expense $expense): void
    {
        abort_unless($expense->company_id === Auth::user()->company->id, 404);
    }
}