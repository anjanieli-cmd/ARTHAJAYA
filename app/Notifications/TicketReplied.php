<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketReplied extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket, public TicketReply $reply)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'      => 'ticket_replied',
            'ticket_id' => $this->ticket->id,
            'title'     => 'Balasan Baru di Tiket',
            'message'   => $this->reply->user->name . ' membalas tiket "' . $this->ticket->subject . '"',
            'url'       => $this->reply->is_admin_reply
                ? route('staff.tickets.show', $this->ticket->id)
                : route('admin.tickets.show', $this->ticket->id),
        ];
    }
}