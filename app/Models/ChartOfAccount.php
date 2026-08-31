<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'company_id', 'code', 'name', 'type', 'normal_balance', 'is_active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}