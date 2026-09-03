<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpnTax extends Model
{
    protected $table = 'ppn_taxes';

    protected $fillable = [
        'company_id', 'period', 'output', 'input', 'ppn',
        'status', 'due_date', 'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'output'   => 'integer',
        'input'    => 'integer',
        'ppn'      => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}