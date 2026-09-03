<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'billing_period',
        'max_users',
        'is_active',
        'color',
        'icon',
        'features',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}