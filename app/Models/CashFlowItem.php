<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlowItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_type',
        'direction',
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

    public function getSignedAmountAttribute(): float
    {
        return $this->direction === 'masuk' ? (float) $this->amount : -(float) $this->amount;
    }

    public function getPeriodLabelAttribute(): string
    {
        return \Carbon\Carbon::createFromDate($this->period_year, $this->period_month, 1)
            ->translatedFormat('F Y');
    }
}