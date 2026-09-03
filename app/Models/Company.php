<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'status',
        'plan',
        'plan_upgraded_at',
        'currency',
        'industry',
        'city',
        'address',
        'phone',
        'email',
        'website',
        'tax_id',
        'logo',
        'initial_balance',
    ];

    protected function casts(): array
    {
        return [
            'plan_upgraded_at' => 'datetime',
            'initial_balance' => 'decimal:2',
        ];
    }

    /**
     * Setiap kali company baru dibuat, otomatis bikinin COA minimal
     * (Kas, Bank, Modal Pemilik) supaya saldo awal langsung bisa
     * dicatat ke Buku Besar. Akun lain (Piutang, Utang, Beban, dst)
     * diisi manual oleh user lewat menu Chart of Accounts.
     */
    protected static function booted(): void
    {
        static::created(function (Company $company) {
            $company->seedDefaultChartOfAccounts();
        });
    }

    public function seedDefaultChartOfAccounts(): void
    {
        $defaults = [
            ['code' => '1-101', 'name' => 'Kas', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-102', 'name' => 'Bank', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '3-101', 'name' => 'Modal Pemilik', 'type' => 'equity', 'normal_balance' => 'credit'],
        ];

        foreach ($defaults as $account) {
            ChartOfAccount::firstOrCreate(
                ['company_id' => $this->id, 'code' => $account['code']],
                [
                    'name' => $account['name'],
                    'type' => $account['type'],
                    'normal_balance' => $account['normal_balance'],
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Relasi ke User (karyawan/pegawai perusahaan)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke Invoice
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Relasi ke Quote
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Relasi ke Client
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Relasi ke Account (akun kas/bank)
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Relasi ke ChartOfAccount (daftar akun / COA)
     */
    public function chartOfAccounts()
    {
        return $this->hasMany(ChartOfAccount::class);
    }

    /**
     * Relasi ke EmployeeProfile (data karyawan)
     */
    public function employeeProfiles()
    {
        return $this->hasMany(EmployeeProfile::class);
    }

    /**
     * Relasi ke ExpenseSubmission (pengajuan pengeluaran)
     */
    public function expenseSubmissions()
    {
        return $this->hasMany(ExpenseSubmission::class);
    }

    /**
     * Cek apakah company aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Cek apakah plan company ini punya akses ke fitur tertentu.
     * $key harus cocok dengan key yang ada di config/features.php
     *
     * Contoh pakai: $company->hasFeature('payroll')
     */
    public function hasFeature(string $key): bool
    {
        $allowed = config("features.$key", []);

        return in_array($this->plan, $allowed);
    }

    /**
     * Ambil nama perusahaan
     */
    public function getNameAttribute($value): string
    {
        return $value ?? 'Arvessa';
    }

    /**
     * Ambil currency symbol
     */
    public function getCurrencySymbolAttribute(): string
    {
        $symbols = [
            'IDR' => 'Rp',
            'USD' => '$',
            'SGD' => 'S$',
            'MYR' => 'RM',
        ];
        return $symbols[$this->currency ?? 'IDR'] ?? 'Rp';
    }

    /**
     * Cek apakah company memiliki multi-user feature
     */
    public function hasMultiUser(): bool
    {
        return $this->hasFeature('multi_user');
    }

    /**
     * Cek apakah company memiliki payroll feature
     */
    public function hasPayroll(): bool
    {
        return $this->hasFeature('payroll');
    }

    /**
     * Cek apakah company memiliki inventory feature
     */
    public function hasInventory(): bool
    {
        return $this->hasFeature('inventaris');
    }

    /**
     * Cek apakah company memiliki tax feature
     */
    public function hasTax(): bool
    {
        return $this->hasFeature('pajak');
    }

    /**
     * Cek apakah company memiliki budgeting feature
     */
    public function hasBudgeting(): bool
    {
        return $this->hasFeature('anggaran');
    }

    /**
     * Cek apakah company memiliki banking feature
     */
    public function hasBanking(): bool
    {
        return $this->hasFeature('perbankan');
    }

    /**
     * Cek apakah company memiliki report feature
     */
    public function hasReports(): bool
    {
        return $this->hasFeature('laporan');
    }

    /**
     * Cek apakah company memiliki AR/AP feature
     */
    public function hasReceivables(): bool
    {
        return $this->hasFeature('piutang_utang');
    }

    /**
     * Ambil total karyawan aktif
     */
    public function getActiveEmployeesCount(): int
    {
        return $this->users()->where('access_level', 'user')->count();
    }

    /**
     * Ambil total semua karyawan
     */
    public function getTotalEmployeesCount(): int
    {
        return $this->users()->count();
    }
}