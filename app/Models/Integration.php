<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integration extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'provider', 'type',
        'api_key', 'api_secret', 'webhook_url',
        'config', 'status', 'connected_at',
    ];

    protected $casts = [
        'config'       => 'array',
        'connected_at' => 'datetime',
    ];

    protected $hidden = ['api_key', 'api_secret'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}