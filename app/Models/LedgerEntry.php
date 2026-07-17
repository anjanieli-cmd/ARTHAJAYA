<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_code',
        'account_name',
        'transaction_date',
        'description',
        'debit',
        'credit',
        'notes',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function scopeAccount($query, ?string $code)
    {
        return $code ? $query->where('account_code', $code) : $query;
    }
}