<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;

class ReportReplyNoticeEvent extends NotificationBroadCast
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {


        parent::__construct();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.');
    }
}
