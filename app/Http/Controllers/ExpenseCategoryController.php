<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori biaya.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        abort_if(
            ! $company,
            403,
            'Lengkapi setup perusahaan terlebih dahulu.'
        );

        $query = ExpenseCategory::where(
            'company_id',
            $company->id
        )->latest();

        /*
         * Pencarian kategori
         */
        if ($request->filled('q')) {
            $q = strtolower($request->get('q'));

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw(
                    'LOWER(name) LIKE ?',
                    ["%{$q}%"]
                )
                ->orWhereRaw(
                    'LOWER(description) LIKE ?',
                    ["%{$q}%"]
                );
            });
        }

        $categories = $query->get();

        /*
         * Statistik kategori
         */
        $totalCategories = ExpenseCategory::where(
            'company_id',
            $company->id
        )->count();

        /*
         * Total transaksi pengeluaran
         */
        $totalTransactions = DB::table('expense_submissions')
            ->where('company_id', $company->id)
            ->count();

        /*
         * Total biaya
         */
        $totalExpenses = DB::table('expense_submissions')
            ->where('company_id', $company->id)
            ->sum('amount');

        /*
         * Kategori dengan total pengeluaran terbesar
         */
        $largestCategory = null;
        $largestCategoryAmount = 0;

        foreach ($categories as $category) {
            $amount = DB::table('expense_submissions')
                ->where('company_id', $company->id)
                ->where('category', $category->name)
                ->sum('amount');

            if ($amount > $largestCategoryAmount) {
                $largestCategoryAmount = $amount;
                $largestCategory = $category->name;
            }
        }

        return view(
            'expense-categories.index',
            compact(
                'user',
                'company',
                'categories',
                'totalCategories',
                'totalTransactions',
                'totalExpenses',
                'largestCategory',
                'largestCategoryAmount'
            )
        );
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        $user = Auth::user();
        $company = $user->company;

        abort_if(
            ! $company,
            403,
            'Lengkapi setup perusahaan terlebih dahulu.'
        );

        return view(
            'expense-categories.create',
            compact('user', 'company')
        );
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        abort_if(
            ! $company,
            403,
            'Lengkapi setup perusahaan terlebih dahulu.'
        );

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:expense_categories,name,NULL,id,company_id,' . $company->id,
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori dengan nama tersebut sudah ada.',
        ]);

        $category = ExpenseCategory::create([
            'company_id' => $company->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $this->logActivity(
            'created',
            'Membuat kategori biaya: ' . $category->name,
            $category
        );

        return redirect()
            ->route('expense-categories.index')
            ->with(
                'success',
                'Kategori biaya berhasil dibuat!'
            );
    }

    /**
     * Form edit kategori.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        $this->authorizeCompany($expenseCategory);

        $user = Auth::user();
        $company = $user->company;

        return view(
            'expense-categories.edit',
            compact(
                'user',
                'company',
                'expenseCategory'
            )
        );
    }

    /**
     * Update kategori.
     */
    public function update(
        Request $request,
        ExpenseCategory $expenseCategory
    ) {
        $this->authorizeCompany($expenseCategory);

        $company = $expenseCategory->company;

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:expense_categories,name,' .
                    $expenseCategory->id .
                    ',id,company_id,' .
                    $company->id,
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori dengan nama tersebut sudah ada.',
        ]);

        $oldName = $expenseCategory->name;

        $expenseCategory->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        /*
         * CATAT RIWAYAT AKTIVITAS
         */
        $this->logActivity(
            'updated',
            'Mengupdate kategori biaya: ' .
                $oldName .
                ' menjadi ' .
                $expenseCategory->name,
            $expenseCategory
        );

        return redirect()
            ->route('expense-categories.index')
            ->with(
                'success',
                'Kategori biaya berhasil diperbarui!'
            );
    }

    /**
     * Hapus kategori.
     */
    public function destroy(
        ExpenseCategory $expenseCategory
    ) {
        $this->authorizeCompany($expenseCategory);

        /*
         * Simpan nama sebelum data dihapus
         * agar bisa dimasukkan ke riwayat.
         */
        $categoryName = $expenseCategory->name;

        /*
         * CATAT RIWAYAT AKTIVITAS
         * sebelum record dihapus.
         */
        $this->logActivity(
            'deleted',
            'Menghapus kategori biaya: ' . $categoryName,
            $expenseCategory
        );

        $expenseCategory->delete();

        return redirect()
            ->route('expense-categories.index')
            ->with(
                'success',
                'Kategori biaya berhasil dihapus!'
            );
    }

    /**
     * Pastikan kategori milik company user yang sedang login.
     */
    private function authorizeCompany(
        ExpenseCategory $expenseCategory
    ): void {
        abort_unless(
            $expenseCategory->company_id ===
                auth()->user()->company_id,
            403
        );
    }

    /**
     * Mencatat aktivitas ke sistem Riwayat Aktivitas.
     *
     * Menggunakan method dari App\Traits\LogsActivity.
     */
    protected function logActivity(
        string $action,
        string $description,
        $subject = null
    ): void {
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject
                ? get_class($subject)
                : null,
            'subject_id' => $subject->id ?? null,
            'ip_address' => request()->ip(),
        ]);
    }
}