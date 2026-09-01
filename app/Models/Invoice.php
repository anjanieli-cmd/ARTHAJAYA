<?php

namespace App\Models;

use App\Traits\LogsActivity;
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
    use LogsActivity; // <-- otomatis catet riwayat pas create/update/delete

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

    /**
     * Teks riwayat yang lebih manusiawi buat trait LogsActivity.
     * Kalau method ini dihapus, trait tetap jalan pakai teks generik fallback.
     */
    public function activityDescription(string $event): string
    {
        $amount = 'Rp' . number_format((float) $this->total, 0, ',', '.');

        return match ($event) {
            'created' => "Membuat faktur {$this->invoice_number} senilai {$amount}",
            'updated' => "Memperbarui faktur {$this->invoice_number}"
                . ($this->wasChanged('status') ? " — status jadi \"{$this->status}\"" : " (senilai {$amount})"),
            'deleted' => "Menghapus faktur {$this->invoice_number}",
            default   => "Mengubah faktur {$this->invoice_number}",
        };
    }
}