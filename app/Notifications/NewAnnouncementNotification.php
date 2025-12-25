<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewAnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $content,
        public string $priority = 'normal'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => '📢 ' . $this->title,
            'message' => $this->content,
            'type' => $this->priority === 'urgent' ? 'warning' : 'info',
            'action_url' => route('member.dashboard'),
            'action_text' => 'Lihat',
        ];
    }
}
