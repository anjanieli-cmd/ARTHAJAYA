<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\JournalEntry;
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
            // COA minimal (Kas, Bank, Modal Pemilik) otomatis ke-seed
            // lewat Company::booted() waktu baris di atas jalan.

            // ===== RIWAYAT: perusahaan baru terdaftar =====
            ActivityLog::record(
                'register_company',
                "Mendaftarkan perusahaan \"{$company->name}\".",
                $company
            );

            $account = $company->accounts()->create([
                'bank_name'           => $data['bank_name'] ?? null,
                'account_name'        => $data['company_name'],
                'account_number'      => '-',
                'initial_balance'     => $data['initial_balance'] ?? 0,
                'chart_of_account_id' => $this->resolveOpeningAccountId($company, $data['bank_name'] ?? null),
            ]);

            $this->syncOpeningBalanceJournal($company, $account, (float) ($data['initial_balance'] ?? 0));

            // ===== RIWAYAT: saldo awal dicatat =====
            $currencySymbol = match ($company->currency) {
                'USD'   => '$',
                'SGD'   => 'S$',
                'MYR'   => 'RM',
                default => 'Rp',
            };
            ActivityLog::record(
                'set_initial_balance',
                "Mencatat saldo awal {$currencySymbol}" . number_format($account->initial_balance, 0, ',', '.')
                    . ($account->bank_name ? " di rekening {$account->bank_name}." : '.'),
                $account
            );

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

            // Simpan nilai lama buat dibandingin, khusus saldo awal
            $oldBalance = optional($company->accounts()->first())->initial_balance;

            $company->update([
                'name'               => $data['company_name'],
                'industry'           => $data['industry'] ?? null,
                'city'               => $data['city'] ?? null,
                'logo'               => $logoPath,
                'currency'           => $data['currency'] ?? 'IDR',
                'fiscal_start_month' => $data['fiscal_start_month'] ?? null,
                'fiscal_year'        => $data['fiscal_year'] ?? null,
            ]);

            // Jaga-jaga buat company lama yang dibuat sebelum fitur
            // auto-seed COA ini ada -- pastikan Kas/Bank/Modal ada.
            $company->seedDefaultChartOfAccounts();

            // ===== RIWAYAT: profil perusahaan diubah =====
            ActivityLog::record(
                'update_company_profile',
                "Memperbarui profil perusahaan \"{$company->name}\".",
                $company
            );

            $accountData = [
                'bank_name'           => $data['bank_name'] ?? null,
                'account_name'        => $data['company_name'],
                'account_number'      => '-',
                'initial_balance'     => $data['initial_balance'] ?? 0,
                'chart_of_account_id' => $this->resolveOpeningAccountId($company, $data['bank_name'] ?? null),
            ];

            $account = $company->accounts()->first();
            if ($account) {
                $account->update($accountData);
            } else {
                $account = $company->accounts()->create($accountData);
            }

            // ===== RIWAYAT: kalau saldo awal berubah, catat perubahannya =====
            $newBalance = $account->initial_balance;
            if ((float) $oldBalance !== (float) $newBalance) {
                $currencySymbol = match ($company->currency) {
                    'USD'   => '$',
                    'SGD'   => 'S$',
                    'MYR'   => 'RM',
                    default => 'Rp',
                };
                ActivityLog::record(
                    'update_initial_balance',
                    "Mengubah saldo awal dari {$currencySymbol}" . number_format($oldBalance ?? 0, 0, ',', '.')
                        . " menjadi {$currencySymbol}" . number_format($newBalance, 0, ',', '.') . '.',
                    $account
                );
            }

            $this->syncOpeningBalanceJournal($company, $account, (float) ($data['initial_balance'] ?? 0));

            return redirect()->route('onboarding.show')->with('updated', true);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Onboarding update error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan sistem: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Tentuin akun COA yang jadi pasangan saldo awal.
     * "Kas Tunai (tanpa bank)" atau kosong -> akun Kas (1-101).
     * Nama bank lain (BCA, BRI, dst) -> akun Bank (1-102).
     */
    private function resolveOpeningAccountId(Company $company, ?string $bankName): ?int
    {
        $isCash = empty($bankName) || $bankName === 'Kas Tunai (tanpa bank)';
        $code = $isCash ? '1-101' : '1-102';

        return ChartOfAccount::where('company_id', $company->id)
            ->where('code', $code)
            ->value('id');
    }

    /**
     * Sinkronkan saldo awal ke Buku Besar sebagai 2 baris journal entry
     * berpasangan (debit ke Kas/Bank, kredit ke Modal Pemilik).
     * Dipanggil ulang tiap kali saldo awal diedit lewat halaman profil,
     * supaya nggak nyatet dobel -- entry lama di-update, bukan ditambah.
     */
    private function syncOpeningBalanceJournal(Company $company, Account $account, float $amount): void
    {
        $existing = JournalEntry::where('reference_type', 'account_opening_balance')
            ->where('reference_id', $account->id)
            ->get();

        // Saldo 0 atau akun COA belum ketemu -> hapus entry lama kalau ada.
        if ($amount <= 0 || ! $account->chart_of_account_id) {
            JournalEntry::destroy($existing->pluck('id'));
            return;
        }

        $equityAccountId = ChartOfAccount::where('company_id', $company->id)
            ->where('code', '3-101')
            ->value('id');

        if (! $equityAccountId) {
            Log::warning("Akun Modal Pemilik (3-101) tidak ditemukan untuk company #{$company->id}, saldo awal tidak dicatat ke Buku Besar.");
            return;
        }

        $description = 'Saldo awal - ' . ($account->bank_name ?: 'Kas');

        $debitEntry = $existing->first(fn ($e) => (float) $e->debit > 0);
        $creditEntry = $existing->first(fn ($e) => (float) $e->credit > 0);

        $payloadDebit = [
            'company_id'          => $company->id,
            'chart_of_account_id' => $account->chart_of_account_id,
            'transaction_date'    => now()->format('Y-m-d'),
            'description'         => $description,
            'debit'               => $amount,
            'credit'              => 0,
            'reference_type'      => 'account_opening_balance',
            'reference_id'        => $account->id,
        ];

        $payloadCredit = [
            'company_id'          => $company->id,
            'chart_of_account_id' => $equityAccountId,
            'transaction_date'    => now()->format('Y-m-d'),
            'description'         => $description,
            'debit'               => 0,
            'credit'              => $amount,
            'reference_type'      => 'account_opening_balance',
            'reference_id'        => $account->id,
        ];

        $debitEntry ? $debitEntry->update($payloadDebit) : JournalEntry::create($payloadDebit);
        $creditEntry ? $creditEntry->update($payloadCredit) : JournalEntry::create($payloadCredit);
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