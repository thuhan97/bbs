<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CaculateLateTimeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $startDate;
    public $endDate;
    /**
     * @var array
     */
    public $userIds;

    /**
     * Create a new event instance.
     *
     * @param       $startDate
     * @param       $endDate
     * @param array $userIds
     */
    public function __construct($startDate, $endDate, $userIds = [])
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userIds = $userIds;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
