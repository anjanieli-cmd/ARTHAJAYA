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
}