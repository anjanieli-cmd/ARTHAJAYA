<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    protected $fillable = [
        'company_id', 'vendor', 'bill_number', 'date', 'due_date',
        'category', 'notes', 'status', 'amount',
    ];

    protected $casts = [
        'date'     => 'date',
        'due_date' => 'date',
        'amount'   => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}