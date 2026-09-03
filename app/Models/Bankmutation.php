<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankMutation extends Model
{
    protected $fillable = [
        'company_id', 'account_id', 'description', 'date',
        'type', 'amount', 'balance', 'category', 'notes',
    ];

    protected $casts = [
        'date'    => 'date',
        'amount'  => 'integer',
        'balance' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}