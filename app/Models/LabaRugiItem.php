<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugiItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'name',
        'amount',
        'period_month',
        'period_year',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function scopePeriod($query, int $month, int $year)
    {
        return $query->where('period_month', $month)->where('period_year', $year);
    }

    public function getPeriodLabelAttribute(): string
    {
        return \Carbon\Carbon::createFromDate($this->period_year, $this->period_month, 1)
            ->translatedFormat('F Y');
    }
}