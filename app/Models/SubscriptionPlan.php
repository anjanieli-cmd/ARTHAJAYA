<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'billing_period',
        'max_users', 'is_active', 'color', 'icon', 'features',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price'     => 'integer',
            'features'  => 'array',
        ];
    }

    /**
     * Semua company yang memakai paket ini.
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function calculateExpiryDate(): \Carbon\Carbon
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