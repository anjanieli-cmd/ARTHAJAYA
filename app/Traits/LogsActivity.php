<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

/**
 * Tambahkan trait ini ke controller mana pun untuk mencatat riwayat
 * aktivitas CRUD secara otomatis ke tabel activity_logs.
 *
 * Contoh pakai:
 *   $this->logActivity('created', 'Membuat pengeluaran: ' . $expense->description, $expense);
 *   $this->logActivity('updated', 'Mengupdate payroll: ' . $payroll->employee->name, $payroll);
 *   $this->logActivity('deleted', 'Menghapus tagihan #' . $payable->bill_number, $payable);
 */
trait LogsActivity
{
    protected function logActivity(string $action, string $description, $subject = null): void
    {
        ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject->id ?? null,
            'ip_address'   => request()->ip(),
        ]);
    }
}