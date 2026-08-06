<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        try {
            $data = $this->validateData($request);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                // Tambahkan validasi tambahan untuk memastikan file benar-benar terupload
                $file = $request->file('logo');
                if ($file->isValid()) {
                    $logoPath = $file->store('company-logos', 'public');
                } else {
                    return back()->withErrors(['logo' => 'File logo tidak valid, coba upload ulang.'])->withInput();
                }
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

            \App\Models\AdminNotification::notify(
                'new_company',
                'Company baru terdaftar',
                "{$company->name} baru saja menyelesaikan onboarding.",
                'building'
            );

            return redirect()->route('onboarding.show')->with('completed', true);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Onboarding store error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan sistem: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update profil perusahaan yang sudah ada (dipakai halaman profil).
     */
    public function update(Request $request)
    {
        try {
            $data = $this->validateData($request);

            $user    = $request->user();
            $company = $user->company;

            if (! $company) {
                return redirect()->route('onboarding.show')
                    ->withErrors(['company' => 'Perusahaan tidak ditemukan. Silakan lengkapi setup awal dulu.']);
            }

            $logoPath = $company->logo;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                if ($file->isValid()) {
                    // Hapus logo lama kalau ada
                    if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                        \Storage::disk('public')->delete($company->logo);
                    }
                    $logoPath = $file->store('company-logos', 'public');
                } else {
                    return back()->withErrors(['logo' => 'File logo tidak valid, coba upload ulang.'])->withInput();
                }
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

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Onboarding update error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan sistem: ' . $e->getMessage()])->withInput();
        }
    }

    private function validateData(Request $request): array
    {
        // Cek ukuran file upload di level PHP
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $maxFileSize = ini_get('upload_max_filesize');
            $maxPostSize = ini_get('post_max_size');
            
            // Log warning kalau limit kecil
            if ((int) $maxFileSize < 10) {
                Log::warning('upload_max_filesize di PHP kecil: ' . $maxFileSize);
            }
        }

        return $request->validate([
            'company_name'        => 'required|string|max:255',
            'industry'            => 'nullable|string|max:100',
            'city'                => 'nullable|string|max:100',
            'logo'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            'currency'            => 'nullable|string|max:5',
            'fiscal_start_month'  => 'nullable|string|max:20',
            'fiscal_year'         => 'nullable|integer|min:2020|max:2100',
            'bank_name'           => 'nullable|string|max:100',
            'initial_balance'     => 'nullable|numeric|min:0|max:9999999999999.99',
        ], [
            'logo.max' => 'Ukuran logo maksimal 5MB. Silakan kompres atau gunakan gambar yang lebih kecil.',
            'logo.image' => 'File harus berupa gambar (JPG, PNG, GIF, atau WebP).',
            'logo.mimes' => 'Format gambar tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.',
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'initial_balance.max' => 'Saldo awal terlalu besar, cek kembali angkanya.',
            'fiscal_year.min' => 'Tahun fiskal minimal 2020.',
            'fiscal_year.max' => 'Tahun fiskal maksimal 2100.',
        ]);
    }
}