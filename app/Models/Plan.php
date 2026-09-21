<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Plan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'billing_period',
        'duration_value',
        'max_users',
        'is_active',
        'color',
        'icon',
        'features',
        'feature_flags',
    ];

    protected function casts(): array
    {
        return [
            'is_active'      => 'boolean',
            'duration_value' => 'integer',
            'feature_flags'  => 'array',
        ];
    }

    /**
     * Hitung tanggal expired berdasarkan billing_period & duration_value.
     */
    public function calculateExpiryDate(): Carbon
    {
        return match ($this->billing_period) {
            'minutes' => now()->addMinutes($this->duration_value),
            'hours'   => now()->addHours($this->duration_value),
            'days'    => now()->addDays($this->duration_value),
            'monthly' => now()->addMonths($this->duration_value),
            'yearly'  => now()->addYears($this->duration_value),
            default   => now()->addMonth(),
        };
    }

    /**
     * Label periode buat ditampilin di UI (checkout, pricing, dll).
     * Satu sumber kebenaran, biar gak ada lagi ternary manual
     * "billing_period === 'monthly' ? ... : ..." yang cuma nutup
     * 2 dari 5 kemungkinan value billing_period.
     */
    public function getPeriodLabelAttribute(): string
    {
        return match ($this->billing_period) {
            'minutes' => '/menit',
            'hours'   => '/jam',
            'days'    => '/hari',
            'monthly' => '/bulan',
            'yearly'  => '/tahun',
            default   => '',
        };
    }

    /**
     * Versi "nama panjang" buat teks kayak "Langganan Bulanan".
     * Dipakai di badge/header checkout.
     */
    public function getPeriodNameAttribute(): string
    {
        return match ($this->billing_period) {
            'minutes' => 'Langganan per Menit',
            'hours'   => 'Langganan per Jam',
            'days'    => 'Langganan Harian',
            'monthly' => 'Langganan Bulanan',
            'yearly'  => 'Langganan Tahunan',
            default   => $this->name,
        };
    }

    /**
     * Semua company yang memakai paket ini (dicocokkan lewat slug,
     * bukan foreign key — lihat Company::hasFeature()).
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'plan', 'slug');
    }
}