<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'subject', 'category',
        'priority', 'status', 'message', 'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'open' => 'Terbuka',
            'in_progress' => 'Diproses',
            'closed' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    public function priorityLabel(): string
    {
        return match ($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            default => ucfirst($this->priority),
        };
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'technical' => 'Teknis',
            'billing' => 'Tagihan',
            'feature_request' => 'Permintaan Fitur',
            'other' => 'Lainnya',
            default => ucfirst($this->category),
        };
    }
}