<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class InvoiceOverdueNotification extends Notification
{
    public function __construct(protected Invoice $invoice)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $clientName = $this->invoice->client->name ?? 'Klien';

        return [
            'title'   => 'Faktur Terlambat',
            'message' => "Faktur {$this->invoice->invoice_number} — {$clientName} sudah jatuh tempo.",
            'icon'    => 'invoice',
            'level'   => 'danger',
            'url'     => route('invoices.show', $this->invoice->id),
        ];
    }
}