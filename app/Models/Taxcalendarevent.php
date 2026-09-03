<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxCalendarEvent extends Model
{
    protected $fillable = [
        'company_id', 'title', 'date', 'type', 'status', 'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}