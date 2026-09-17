<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionNotification extends Model
{
    protected $fillable = [
        'company_id',
        'type',
        'plan_expires_at_snapshot',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'plan_expires_at_snapshot' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Cek apakah notifikasi tipe tertentu sudah pernah dikirim
     * untuk company ini, di siklus expired_at yang sama.
     */
    public static function alreadySent(int $companyId, string $type, $planExpiresAt): bool
    {
        return static::where('company_id', $companyId)
            ->where('type', $type)
            ->where('plan_expires_at_snapshot', $planExpiresAt)
            ->exists();
    }

    /**
     * Catat bahwa notifikasi tipe tertentu sudah dikirim.
     */
    public static function markSent(int $companyId, string $type, $planExpiresAt): void
    {
        static::create([
            'company_id' => $companyId,
            'type' => $type,
            'plan_expires_at_snapshot' => $planExpiresAt,
            'sent_at' => now(),
        ]);
    }
}