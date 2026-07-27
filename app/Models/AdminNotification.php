<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'type', 'title', 'message', 'icon', 'url', 'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    /**
     * Helper singkat buat bikin notifikasi baru dari mana pun di kode.
     * Contoh: AdminNotification::notify('new_user', 'User baru mendaftar', 'Budi Santoso baru saja membuat akun.');
     */
    public static function notify(string $type, string $title, string $message, string $icon = 'inbox', ?string $url = null): self
    {
        return static::create([
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'icon'    => $icon,
            'url'     => $url,
        ]);
    }
}