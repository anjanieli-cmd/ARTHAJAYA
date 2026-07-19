<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client',
        'invoice',
        'date',
        'due',
        'status',
        'amount',
        'items',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'due' => 'date',
        'amount' => 'decimal:2',
        'items' => 'array',
    ];

    /**
     * Status constants
     */
    const STATUS_LANCAR = 'lancar';
    const STATUS_JATUH_TEMPO = 'jatuh_tempo';
    const STATUS_LUNAS = 'lunas';

    /**
     * Get all statuses.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_LANCAR => 'Lancar',
            self::STATUS_JATUH_TEMPO => 'Jatuh Tempo',
            self::STATUS_LUNAS => 'Lunas',
        ];
    }

    /**
     * Get status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_LANCAR => 'emerald',
            self::STATUS_JATUH_TEMPO => 'danger',
            self::STATUS_LUNAS => 'text-mute',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Scope a query to only include active receivables.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_LANCAR, self::STATUS_JATUH_TEMPO]);
    }

    /**
     * Scope a query to only include overdue receivables.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_JATUH_TEMPO);
    }

    /**
     * Scope a query to only include paid receivables.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_LUNAS);
    }

    /**
     * Check if receivable is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        return $this->status === self::STATUS_JATUH_TEMPO && $this->due < now();
    }

    /**
     * Check if receivable is paid.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === self::STATUS_LUNAS;
    }

    /**
     * Check if receivable is current.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->status === self::STATUS_LANCAR;
    }

    /**
     * Get formatted amount.
     *
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get days overdue.
     *
     * @return int
     */
    public function getDaysOverdueAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->due);
    }

    /**
     * Get aging category.
     *
     * @return string
     */
    public function getAgingCategoryAttribute()
    {
        if ($this->isPaid()) {
            return 'Lunas';
        }

        $days = $this->days_overdue;
        
        if ($days <= 0) {
            return 'Current';
        } elseif ($days <= 30) {
            return '1-30 Hari';
        } elseif ($days <= 60) {
            return '31-60 Hari';
        } elseif ($days <= 90) {
            return '61-90 Hari';
        } else {
            return '> 90 Hari';
        }
    }
}