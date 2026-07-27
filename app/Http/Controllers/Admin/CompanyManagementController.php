<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyManagementController extends Controller
{
    /**
     * Tampilkan semua company yang terdaftar di sistem.
     */
    public function index(Request $request)
    {
        $companies = Company::withCount(['users', 'invoices', 'clients', 'quotes'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total'     => Company::count(),
            'active'    => Company::where('status', 'active')->count(),
            'suspended' => Company::where('status', 'suspended')->count(),
        ];

        return view('admin.companies.index', compact('companies', 'stats'));
    }

    /**
     * Tampilkan detail 1 company (untuk lihat/ubah status).
     */
    public function edit(Company $company)
    {
        $company->loadCount(['users', 'invoices', 'clients', 'quotes']);
        $company->load(['users' => fn ($q) => $q->latest()->limit(5)]);

        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update status company (active / suspended).
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,suspended'],
        ]);

        $company->update($data);

        return redirect()->route('admin.companies.index')
            ->with('success', "Status {$company->name} berhasil diperbarui.");
    }
}