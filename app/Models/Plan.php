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
    ];

    protected function casts(): array
    {
        return [
            'is_active'      => 'boolean',
            'duration_value' => 'integer',
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
}