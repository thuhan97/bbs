<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SearchEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $keyword;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($keyword)
    {
        //
        $this->keyword = $keyword;
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
