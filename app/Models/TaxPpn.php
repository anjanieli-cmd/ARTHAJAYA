<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxPpn extends Model
{
    protected $table = 'tax_ppn';

    protected $fillable = [
        'company_id', 'period', 'output', 'input', 'ppn', 'status', 'due', 'notes',
    ];

    protected $casts = [
        'output' => 'decimal:2',
        'input' => 'decimal:2',
        'ppn' => 'decimal:2',
        'due' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}