<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    use LogsActivity;

    /**
     * Menampilkan daftar pengeluaran.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Expense::with('category')
            ->where('company_id', $company->id)
            ->latest();

        // Search berdasarkan deskripsi atau nama kategori
        if ($request->filled('q')) {
            $q = strtolower($request->q);

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw(
                    'LOWER(description) LIKE ?',
                    ["%{$q}%"]
                )
                ->orWhereHas('category', function ($categoryQuery) use ($q) {
                    $categoryQuery->whereRaw(
                        'LOWER(name) LIKE ?',
                        ["%{$q}%"]
                    );
                });
            });
        }

        $expenses = $query->get();

        if ($request->ajax()) {
            return view(
                'expenses.index',
                compact('user', 'company', 'expenses')
            )->render();
        }

        return view(
            'expenses.index',
            compact('user', 'company', 'expenses')
        );
    }

    /**
     * Form tambah pengeluaran.
     */
    public function create()
    {
        $user = Auth::user();
        $company = $user->company;

        // Ambil kategori dari tabel expense_categories
        // khusus untuk company yang sedang login.
        $categories = ExpenseCategory::where(
            'company_id',
            $company->id
        )
            ->orderBy('name')
            ->get();

        return view(
            'expenses.create',
            compact(
                'user',
                'company',
                'categories'
            )
        );
    }

    /**
     * Simpan pengeluaran baru.
     */
    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'expense_category_id' => [
                'nullable',
                'integer',
                Rule::exists('expense_categories', 'id')
                    ->where(function ($query) use ($company) {
                        $query->where(
                            'company_id',
                            $company->id
                        );
                    }),
            ],

            'date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'nullable',
                'in:lunas,pending',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $expense = Expense::create([
            'company_id' => $company->id,

            'expense_category_id' =>
                $data['expense_category_id'] ?? null,

            'description' =>
                $data['description'],

            'date' =>
                $data['date'],

            'amount' =>
                (int) $data['amount'],

            'status' =>
                $data['status'] ?? 'pending',

            'notes' =>
                $data['notes'] ?? null,

            'created_by' =>
                Auth::id(),
        ]);

        $this->logActivity(
            'created',
            "Mencatat pengeluaran: {$expense->description}",
            $expense
        );

        return redirect()
            ->route('expenses.index')
            ->with(
                'success',
                'Pengeluaran berhasil dicatat!'
            );
    }

    /**
     * Detail pengeluaran.
     */
    public function show(Expense $expense)
    {
        $this->authorizeCompany($expense);

        $user = Auth::user();
        $company = $user->company;

        $expense->load('category');

        return view(
            'expenses.show',
            compact(
                'user',
                'company',
                'expense'
            )
        );
    }

    /**
     * Form edit pengeluaran.
     */
    public function edit(Expense $expense)
    {
        $this->authorizeCompany($expense);

        $user = Auth::user();
        $company = $user->company;

        // Ambil kategori dari database
        $categories = ExpenseCategory::where(
            'company_id',
            $company->id
        )
            ->orderBy('name')
            ->get();

        return view(
            'expenses.edit',
            compact(
                'user',
                'company',
                'expense',
                'categories'
            )
        );
    }

    /**
     * Update pengeluaran.
     */
    public function update(
        Request $request,
        Expense $expense
    ) {
        $this->authorizeCompany($expense);

        $company = Auth::user()->company;

        $data = $request->validate([
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'expense_category_id' => [
                'nullable',
                'integer',
                Rule::exists('expense_categories', 'id')
                    ->where(function ($query) use ($company) {
                        $query->where(
                            'company_id',
                            $company->id
                        );
                    }),
            ],

            'date' => [
                'required',
                'date',
            ],

            'status' => [
                'nullable',
                'in:lunas,pending',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $expense->update([
            'description' =>
                $data['description'],

            'expense_category_id' =>
                $data['expense_category_id'] ?? null,

            'date' =>
                $data['date'],

            'status' =>
                $data['status'] ?? 'pending',

            'amount' =>
                (int) $data['amount'],

            'notes' =>
                $data['notes'] ?? null,
        ]);

        $this->logActivity(
            'updated',
            "Mengupdate pengeluaran: {$expense->description}",
            $expense
        );

        return redirect()
            ->route('expenses.index')
            ->with(
                'success',
                'Pengeluaran berhasil diupdate!'
            );
    }

    /**
     * Hapus pengeluaran.
     */
    public function destroy(Expense $expense)
    {
        $this->authorizeCompany($expense);

        $desc = $expense->description;

        $expense->delete();

        $this->logActivity(
            'deleted',
            "Menghapus pengeluaran: {$desc}"
        );

        return redirect()
            ->route('expenses.index')
            ->with(
                'success',
                'Pengeluaran berhasil dihapus!'
            );
    }

    /**
     * Pastikan expense milik company yang sedang login.
     */
    private function authorizeCompany(
        Expense $expense
    ): void {
        abort_unless(
            $expense->company_id ===
                Auth::user()->company->id,
            404
        );
    }
}