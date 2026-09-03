<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxPph extends Model
{
    protected $table = 'tax_pph';

    protected $fillable = [
        'company_id', 'period', 'gross', 'deduction', 'taxable', 'tax', 'status', 'due', 'notes',
    ];

    protected $casts = [
        'gross' => 'decimal:2',
        'deduction' => 'decimal:2',
        'taxable' => 'decimal:2',
        'tax' => 'decimal:2',
        'due' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}