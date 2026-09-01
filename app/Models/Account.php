<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'company_id',
        'chart_of_account_id',
        'bank_name',
        'account_name',
        'account_number',
        'initial_balance',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Akun COA (Kas / Bank) yang jadi pasangan rekening ini,
     * dipakai buat nyatet saldo awal & mutasi ke Buku Besar.
     */
    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}