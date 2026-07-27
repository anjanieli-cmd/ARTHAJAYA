<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    protected function casts(): array
    {
        return [
            //
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}