<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'description', 'subject_type', 'subject_id', 'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper singkat buat mencatat aktivitas dari mana pun di kode.
     * Contoh: ActivityLog::record('delete_user', "Menghapus user Budi.", $user);
     */
    public static function record(string $action, string $description, $subject = null): self
    {
        return static::create([
            'user_id'      => auth()->id(),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'ip_address'   => request()->ip(),
        ]);
    }
}