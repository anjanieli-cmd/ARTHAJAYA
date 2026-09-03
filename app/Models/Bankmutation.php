<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class BankMutation extends Model
{
    use LogsActivity;

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