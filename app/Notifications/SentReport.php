<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SentReport extends Notification
{
    use Queueable;
    /**
     * @var Report
     */
    private $report;

    /**
     * Create a new notification instance.
     *
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        //
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'type' => NOTIFICATION_TYPE['report'],
            'sender_name' => $notifiable->name,
            'sender_avatar' => $notifiable->avatar,
            'content' => $this->report->title,
        ]);
    }
}
