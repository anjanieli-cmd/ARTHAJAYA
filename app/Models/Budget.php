<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'company_id',
        'category',
        'period',
        'target',
        'actual',
        'progress',
        'status',
        'notes',
    ];

    protected $casts = [
        'target'   => 'integer',
        'actual'   => 'integer',
        'progress' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}