<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DontReportNotice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $data;
    private $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $title, $content, $url)
    {
        $this->data = [
            'title' => $title,
            'content' => $content,
            'image_url' => JVB_LOGO_URL,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['report']],
            'logo_id' => NOTIFICATION_TYPE['report'],
            'url' => $url,
        ];
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->userId);
    }
}
