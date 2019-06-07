<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AskPermissionNoticeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($datas,$title,$url,$content,$user_id)
    {
        $this->id=$user_id;
        $this->data = [
            'id' => $datas->id,
            'name' =>  ($datas->user->name ?? $datas->creator->name).SPACE.$title,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['day_off_create']],
            'image_url' => $datas->user->avatar ?? $datas->creator->avatar,
            'introduction' => $content,
            'url' => $url,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.'.$this->id);
    }
}
