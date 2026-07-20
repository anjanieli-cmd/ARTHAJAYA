<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Notifications\InvoiceOverdueNotification;
use App\Notifications\InvoiceDueSoonNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckInvoiceStatuses extends Command
{
    protected $signature = 'invoices:check-status';
    protected $description = 'Cek faktur overdue & jatuh tempo lalu kirim notifikasi ke semua user di company terkait';

    public function handle(): void
    {
        // Faktur berstatus "sent" yang sudah lewat jatuh tempo
        $overdue = Invoice::with('company.users')
            ->where('status', 'sent')
            ->where('due_date', '<', now())
            ->get();

        foreach ($overdue as $invoice) {
            $recipients = $invoice->company->users;
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new InvoiceOverdueNotification($invoice));
            }
        }

        // Faktur berstatus "sent" yang jatuh tempo dalam 3 hari ke depan
        $dueSoon = Invoice::with('company.users')
            ->where('status', 'sent')
            ->whereBetween('due_date', [now(), now()->addDays(3)])
            ->get();

        foreach ($dueSoon as $invoice) {
            $recipients = $invoice->company->users;
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new InvoiceDueSoonNotification($invoice));
            }
        }

        $this->info('Selesai cek status faktur: ' . $overdue->count() . ' overdue, ' . $dueSoon->count() . ' due soon.');
    }
}