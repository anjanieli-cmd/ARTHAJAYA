<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'      => 'ticket_created',
            'ticket_id' => $this->ticket->id,
            'title'     => 'Tiket Bantuan Baru',
            'message'   => $this->ticket->user->name . ' mengajukan tiket: "' . $this->ticket->subject . '"',
            'url'       => route('admin.tickets.show', $this->ticket->id),
        ];
    }
}