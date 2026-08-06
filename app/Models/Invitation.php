<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Invitation extends Model
{
    protected $fillable = [
        'code', 'company_id', 'created_by', 'expires_at', 'used_at', 'used_by',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at'    => 'datetime',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isValid(): bool
    {
        return is_null($this->used_at) && $this->expires_at->isFuture();
    }

    public static function generateForCompany(int $companyId, int $createdBy): self
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return self::create([
            'code'       => $code,
            'company_id' => $companyId,
            'created_by' => $createdBy,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
    }
}