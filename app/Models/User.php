<?php

namespace App\Models;

use App\Enums\AccessLevel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

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
        'name',
        'email',
        'password',
        'company_id',
        'phone',
        'position',
        'avatar',
        'role',
        'access_level',
        'two_factor_enabled',
        'password_changed_at',
        'profile_photo',
    ];

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->access_level === AccessLevel::Admin;
    }

    /**
     * Cek access level tertentu, bisa lebih dari satu
     */
    public function hasAccessLevel(AccessLevel ...$levels): bool
    {
        return in_array($this->access_level, $levels);
    }

    /**
     * Relasi ke Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke data kerja karyawan
     */
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    /**
     * Cek apakah user adalah staff atau admin
     */
    public function isStaff(): bool
    {
        return $this->access_level === AccessLevel::Staff
            || $this->access_level === AccessLevel::Admin;
    }

    /**
     * Cek apakah user adalah user biasa
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

        $parts = explode(' ', trim($name));

        if (count($parts) >= 2) {
            return strtoupper(
                substr($parts[0], 0, 1) .
                substr($parts[1], 0, 1)
            );
        }

        return strtoupper(substr($name, 0, 1));
    }

    /**
     * Cek apakah user memiliki foto profil.
     *
     * Menggunakan avatar terlebih dahulu.
     * Jika avatar kosong, cek profile_photo.
     */
    public function hasProfilePhoto(): bool
    {
        return !empty($this->avatar) || !empty($this->profile_photo);
    }

    /**
     * URL foto profil.
     *
     * Prioritas:
     * 1. avatar
     * 2. profile_photo
     *
     * Jika menggunakan disk public:
     *    /storage/...
     *
     * Jika menggunakan Supabase/S3:
     *    Storage::url(...)
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        $photo = $this->avatar ?: $this->profile_photo;

        if (!$photo) {
            return '';
        }

        $disk = config('filesystems.default');

        if ($disk === 'public') {
            return asset('storage/' . $photo);
        }

        return Storage::disk($disk)->url($photo);
    }

    /**
     * URL avatar.
     *
     * Bisa digunakan di Blade dengan:
     * $user->avatar_url
     */
    public function getAvatarUrlAttribute(): ?string
    {
        $photo = $this->avatar ?: $this->profile_photo;

        if (!$photo) {
            return null;
        }

        $disk = config('filesystems.default');

        if ($disk === 'public') {
            return asset('storage/' . $photo);
        }

        return Storage::disk($disk)->url($photo);
    }
}