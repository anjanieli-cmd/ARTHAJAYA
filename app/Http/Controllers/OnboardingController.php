<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function show()
    {
        if (auth()->user()->company_id && !session('completed')) {
            return redirect()->route('dashboard');
        }
        $company = session('completed') ? auth()->user()->company()->with('accounts')->first() : null;
        return view('onboarding', compact('company'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'phone' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string',
            'business_size' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'currency' => 'nullable|string|max:5',
            'timezone' => 'nullable|string',
            'date_format' => 'nullable|string',
            'report_language' => 'nullable|string|max:5',
            'fiscal_start_month' => 'nullable|string',
            'fiscal_year' => 'nullable|integer',
            'bank_name' => 'nullable|string',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'initial_balance' => 'nullable|numeric|min:0',
            'invite_email.*' => 'nullable|email',
        ]);

        // tentuin step mana yang error (buat balikin ke step yg tepat)
        $errorStep = null;

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        $company = \App\Models\Company::create([
            'name' => $data['company_name'],
            'industry' => $data['industry'] ?? null,
            'business_size' => $data['business_size'] ?? null,
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'logo' => $logoPath,
            'currency' => $data['currency'] ?? 'IDR',
            'timezone' => $data['timezone'] ?? null,
            'date_format' => $data['date_format'] ?? null,
            'report_language' => $data['report_language'] ?? 'id',
            'fiscal_start_month' => $data['fiscal_start_month'] ?? null,
            'fiscal_year' => $data['fiscal_year'] ?? null,
        ]);

        $company->accounts()->create([
            'bank_name' => $data['bank_name'] ?? null,
            'account_name' => $data['account_name'] ?? null,
            'account_number' => $data['account_number'] ?? null,
            'initial_balance' => $data['initial_balance'] ?? 0,
        ]);

        $request->user()->update([
            'company_id' => $company->id,
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'],
        ]);

        // TODO: kalau mau, loop $request->invite_email di sini buat kirim undangan (Mail/Notification)

        return redirect()->route('onboarding.show')->with('completed', true);
    }
}