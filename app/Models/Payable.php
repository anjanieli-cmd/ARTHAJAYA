<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    protected $fillable = [
        'company_id', 'vendor', 'bill_number', 'date', 'due',
        'category', 'status', 'amount', 'items', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'due' => 'date',
        'amount' => 'decimal:2',
        'items' => 'array',
    ];

    const STATUS_LANCAR = 'lancar';
    const STATUS_JATUH_TEMPO = 'jatuh_tempo';
    const STATUS_LUNAS = 'lunas';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_LANCAR => 'Lancar',
            self::STATUS_JATUH_TEMPO => 'Jatuh Tempo',
            self::STATUS_LUNAS => 'Lunas',
        ];
    }

    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_LANCAR => 'emerald',
            self::STATUS_JATUH_TEMPO => 'danger',
            self::STATUS_LUNAS => 'text-mute',
        ][$this->status] ?? 'secondary';
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function isOverdue()
    {
        return $this->status === self::STATUS_JATUH_TEMPO && $this->due < now();
    }

    public function isPaid()
    {
        return $this->status === self::STATUS_LUNAS;
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_LANCAR, self::STATUS_JATUH_TEMPO]);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_JATUH_TEMPO);
    }
}