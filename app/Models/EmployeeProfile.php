<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'position',
        'department',
        'basic_salary',
        'phone',
        'address',
        'joined_date',
        'status',
    ];

    protected $casts = [
        'basic_salary' => 'integer',
        'joined_date'  => 'date',
    ];

    /**
     * Akun karyawan yang punya profile ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Perusahaan tempat karyawan ini bekerja.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Cek apakah data kerja karyawan ini sudah dilengkapi Staff.
     */
    public function getIsCompleteAttribute(): bool
    {
        return !is_null($this->position) && !is_null($this->basic_salary);
    }
}