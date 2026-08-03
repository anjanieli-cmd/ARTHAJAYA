<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(protected Announcement $announcement)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'   => $this->announcement->title,
            'message' => $this->announcement->message,
            'icon'    => 'megaphone',
            'level'   => 'info',
            'url'     => '#',
        ];
    }
}