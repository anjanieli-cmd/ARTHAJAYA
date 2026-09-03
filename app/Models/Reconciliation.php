<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Reconciliation extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_id',
        'account_id',
        'period',
        'description',
        'date',
        'bank_balance',
        'book_balance',
        'status',
        'notes',
    ];

    protected $casts = [
        'date'         => 'date',
        'bank_balance' => 'integer',
        'book_balance' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}