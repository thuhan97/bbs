<?php

namespace App\Events;

use App\Helpers\NotificationHelper;
use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationBroadCast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $notification = NotificationHelper::generateNotify($this->data['to_id'],
            $this->data['title'], $this->data['content'],
            $this->data['from_id'], $this->data['logo_id'],
            $this->data['url']);
        Notification::insertAll([$notification]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('bbs');
    }
}
