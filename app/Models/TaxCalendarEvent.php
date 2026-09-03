<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxCalendarEvent extends Model
{
    protected $fillable = ['company_id', 'title', 'date', 'type', 'desc'];

    protected $casts = [
        'date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Status dihitung otomatis dari tanggal, bukan disimpan manual.
     */
    public function getStatusAttribute(): string
    {
        if ($this->date->isPast()) {
            return 'overdue';
        }
        if ($this->date->isToday()) {
            return 'today';
        }
        return 'upcoming';
    }
}