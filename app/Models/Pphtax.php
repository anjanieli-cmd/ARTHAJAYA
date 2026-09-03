<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PphTax extends Model
{
    protected $table = 'pph_taxes';

    protected $fillable = [
        'company_id', 'period', 'gross', 'deduction', 'taxable',
        'tax', 'status', 'due_date', 'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'gross'    => 'integer',
        'deduction'=> 'integer',
        'taxable'  => 'integer',
        'tax'      => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}