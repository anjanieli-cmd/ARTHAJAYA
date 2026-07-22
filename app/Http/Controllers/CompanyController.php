<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $company = $user->company;

        return view('company.edit', compact('user', 'company'));
    }

    public function update(Request $request)
    {
        $company = Auth::user()->company;

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'industry'           => 'nullable|string|max:100',
            'city'               => 'nullable|string|max:100',
            'currency'           => 'required|in:IDR,USD,SGD,MYR',
            'fiscal_start_month' => 'required|string|max:20',
            'fiscal_year'        => 'required|digits:4',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        } else {
            unset($validated['logo']);
        }

        $company->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}