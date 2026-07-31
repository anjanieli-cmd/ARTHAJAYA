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
    ];

    protected function casts(): array
    {
        return [
            'plan_upgraded_at' => 'datetime',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

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
}