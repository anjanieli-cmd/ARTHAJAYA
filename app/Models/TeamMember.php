<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'email', 'role',
        'permissions', 'status', 'invited_at', 'joined_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'invited_at'  => 'datetime',
        'joined_at'   => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function permissionCount(): int
    {
        return count($this->permissions ?? []);
    }
}