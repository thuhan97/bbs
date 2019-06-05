<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WorkExperienceNoticeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($workExperience)
    {
        $this->data = [
            'id' => $workExperience->id,
            'name' =>  $workExperience->user->name,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['post']],
            'image_url' => $workExperience->user->avatar,
            'introduction' => $workExperience->introduction,
            'url' => route('view_experience', $workExperience->id),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('bbs');
    }
}
