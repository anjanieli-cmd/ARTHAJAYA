<?php

namespace App\Models;

use App\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class TaxPpn extends Model
{
    use LogsActivity;

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