<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'company_id',
    'client_id',
    'invoice_number',
    'issue_date',
    'due_date',
    'status',
    'subtotal',
    'tax_amount',
    'total',
    'notes',
])]
class Invoice extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date'   => 'date',
            'subtotal'   => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total'      => 'decimal:2',
        ];
    }

    /**
     * Relasi ke Company pemilik faktur ini.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke Client / klien penerima faktur.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Faktur dianggap terlambat kalau statusnya "sent" dan sudah lewat jatuh tempo.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'sent'
            && $this->due_date
            && $this->due_date->isPast();
    }

    /**
     * Generate nomor faktur unik, format: INV-2026-0001
     */
    public static function generateInvoiceNumber(int $companyId): string
    {
        $year = now()->year;
        $lastNumber = static::where('company_id', $companyId)
            ->whereYear('created_at', $year)
            ->count();

        return sprintf('INV-%d-%04d', $year, $lastNumber + 1);
    }
}