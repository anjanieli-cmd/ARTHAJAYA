<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['company_id', 'name', 'company_name', 'email', 'phone', 'address'])]
class Client extends Model
{
    use HasFactory;

    /**
     * Relasi ke Company pemilik klien ini.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Semua faktur milik klien ini.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}