<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification
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
            'title'   => 'Pembayaran Diterima',
            'message' => "Faktur {$this->invoice->invoice_number} sebesar Rp" . number_format((float) $this->invoice->total, 0, ',', '.') . " telah dibayar.",
            'icon'    => 'receive',
            'level'   => 'success',
            'url'     => route('invoices.show', $this->invoice->id),
        ];
    }
}