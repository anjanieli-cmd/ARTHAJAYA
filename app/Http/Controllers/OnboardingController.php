<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Tampilkan halaman onboarding (kalau company belum ada)
     * atau halaman profil perusahaan (kalau company sudah ada).
     */
    public function show()
    {
        $company = auth()->user()->company()->with('accounts')->first();

        return view('onboarding', [
            'company' => $company,
        ]);
    }

    /**
     * Simpan data onboarding pertama kali (company belum ada).
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        $company = Company::create([
            'name'               => $data['company_name'],
            'industry'           => $data['industry'] ?? null,
            'city'               => $data['city'] ?? null,
            'logo'               => $logoPath,
            'currency'           => $data['currency'] ?? 'IDR',
            'fiscal_start_month' => $data['fiscal_start_month'] ?? null,
            'fiscal_year'        => $data['fiscal_year'] ?? null,
        ]);

        $company->accounts()->create([
            'bank_name'       => $data['bank_name'] ?? null,
            'account_name'    => $data['company_name'],
            'account_number'  => '-',
            'initial_balance' => $data['initial_balance'] ?? 0,
        ]);

        $request->user()->update([
            'company_id' => $company->id,
        ]);

        return redirect()->route('onboarding.show')->with('completed', true);
    }

    /**
     * Update profil perusahaan yang sudah ada (dipakai halaman profil).
     */
    public function update(Request $request)
    {
        $data = $this->validateData($request);

        $user    = $request->user();
        $company = $user->company;

        if (! $company) {
            return redirect()->route('onboarding.show')
                ->withErrors(['company' => 'Perusahaan tidak ditemukan. Silakan lengkapi setup awal dulu.']);
        }

        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update([
            'name'               => $data['company_name'],
            'industry'           => $data['industry'] ?? null,
            'city'               => $data['city'] ?? null,
            'logo'               => $logoPath,
            'currency'           => $data['currency'] ?? 'IDR',
            'fiscal_start_month' => $data['fiscal_start_month'] ?? null,
            'fiscal_year'        => $data['fiscal_year'] ?? null,
        ]);

        $accountData = [
            'bank_name'       => $data['bank_name'] ?? null,
            'account_name'    => $data['company_name'],
            'account_number'  => '-',
            'initial_balance' => $data['initial_balance'] ?? 0,
        ];

        $account = $company->accounts()->first();
        if ($account) {
            $account->update($accountData);
        } else {
            $company->accounts()->create($accountData);
        }

        return redirect()->route('onboarding.show')->with('updated', true);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'company_name'        => 'required|string|max:255',
            'industry'            => 'nullable|string',
            'city'                => 'nullable|string',
            'logo'                => 'nullable|image|max:2048',
            'currency'            => 'nullable|string|max:5',
            'fiscal_start_month'  => 'nullable|string',
            'fiscal_year'         => 'nullable|integer',
            'bank_name'           => 'nullable|string',
            'initial_balance'     => 'nullable|numeric|min:0',
        ]);
    }
}