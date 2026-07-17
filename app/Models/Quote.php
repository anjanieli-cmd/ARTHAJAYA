<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'client_id',
        'quote_number',
        'issue_date',
        'valid_until',
        'status',
        'subtotal',
        'tax_amount',
        'total',
        'notes',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'valid_until' => 'date',
        'subtotal'    => 'decimal:2',
        'tax_amount'  => 'decimal:2',
        'total'       => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // Total selalu dihitung ulang otomatis dari subtotal + pajak setiap kali disimpan.
        static::saving(function (Quote $quote) {
            $quote->total = (float) $quote->subtotal + (float) $quote->tax_amount;
        });

        // Nomor penawaran dibuat otomatis kalau belum diisi, format: QUO-202607-0001
        static::creating(function (Quote $quote) {
            if (empty($quote->quote_number)) {
                $quote->quote_number = static::generateQuoteNumber($quote->company_id);
            }
        });
    }

    public static function generateQuoteNumber(int $companyId): string
    {
        $prefix = 'QUO-' . now()->format('Ym') . '-';

        $last = static::where('company_id', $companyId)
            ->where('quote_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if ($last) {
            $lastNumber = (int) substr($last->quote_number, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}