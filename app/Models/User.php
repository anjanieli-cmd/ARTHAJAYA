<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AccessLevel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'company_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'password_changed_at' => 'datetime',
            'two_factor_enabled'  => 'boolean',
            'access_level'        => AccessLevel::class,
        ];
    }

    protected $fillable = [
        'name', 'email', 'password', 'company_id',
        'phone', 'position', 'avatar', 'role', 'access_level',
        'two_factor_enabled', 'password_changed_at',
        'profile_photo', // Tambahkan ini
    ];

    /**
     * Cek apakah user adalah admin (hak akses sistem)
     */
    public function isAdmin(): bool
    {
        return $this->access_level === AccessLevel::Admin;
    }

    /**
     * Cek access level tertentu, bisa lebih dari satu
     * Contoh: $user->hasAccessLevel(AccessLevel::Admin, AccessLevel::Staff)
     */
    public function hasAccessLevel(AccessLevel ...$levels): bool
    {
        return in_array($this->access_level, $levels);
    }

    /**
     * Relasi ke Company
     * Seorang User memiliki satu Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke data kerja karyawan (posisi, departemen, gaji).
     * Diisi/diedit oleh Staff, bukan si karyawan sendiri.
     */
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    /**
     * Cek apakah user adalah staff atau admin (bisa mengelola data)
     */
    public function isStaff(): bool
    {
        return $this->access_level === AccessLevel::Staff || $this->access_level === AccessLevel::Admin;
    }

    /**
     * Cek apakah user adalah user biasa (bukan staff/admin)
     */
    public function isRegularUser(): bool
    {
        return $this->access_level === AccessLevel::User;
    }

    /**
     * Ambil nama lengkap user
     */
    public function getFullNameAttribute(): string
    {
        return $this->name ?? 'Pengguna';
    }

    /**
     * Ambil inisial user untuk avatar
     */
    public function getInitialsAttribute(): string
    {
        $name = $this->name ?? 'U';
        $parts = explode(' ', $name);
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 1));
    }

    /**
     * Cek apakah user memiliki foto profil
     */
    public function hasProfilePhoto(): bool
    {
        return !empty($this->profile_photo);
    }

    /**
     * Ambil URL foto profil
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return '';
    }
}