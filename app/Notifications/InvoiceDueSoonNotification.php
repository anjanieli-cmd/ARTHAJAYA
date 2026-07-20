<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class InvoiceDueSoonNotification extends Notification
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
        return [
            'title'   => 'Faktur Akan Jatuh Tempo',
            'message' => "Faktur {$this->invoice->invoice_number} akan jatuh tempo pada {$this->invoice->due_date->translatedFormat('d F Y')}.",
            'icon'    => 'invoice',
            'level'   => 'warning',
            'url'     => route('invoices.show', $this->invoice->id),
        ];
    }
}