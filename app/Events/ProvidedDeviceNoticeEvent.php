<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class ProvidedDeviceNoticeEvent extends NotificationBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $dayoff;
    private $user;
    private $type;
    private $toId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($providedDevic,$type)
    {
        $user=Auth::user();
        $url = route('device_index'). "#$providedDevic->id";
        $logoId=NOTIFICATION_TYPE['device'];
        $logoUrld=NOTIFICATION_LOGO[NOTIFICATION_TYPE['device']];
        if ($type == TYPE_DEVICE['send']){
            $title = $user->name .SPACE.__l('device_suggest');
            $this->toId = $providedDevic->manager_id;
            $id=$providedDevic->manager_id;
            $content=$providedDevic->title ?? '';

        }elseif ($type == TYPE_DEVICE['manager_approval']){
            $title = $user->name .SPACE.__l('device_manager_approvel');
            $this->toId = $providedDevic->user_id;
            $id=$providedDevic->user_id;
            $content=$providedDevic->approval_manager ?? '';
        }else{
            $title =__l('device_administrative');
            $this->toId = $providedDevic->user_id;
            $id=$providedDevic->user_id;
            $content=$providedDevic->approval_hcnv ?? '';
            $jvbLogo=JVB_LOGO_URL;
        }
        $this->data = [
            'id' =>  $providedDevic->id,
            'name' => $user->name,
            'title' => $title,
            'content' => $content,
            'image_url' => $jvbLogo ?? $user->avatar,
            'logo_url' =>$logoUrld,
            'logo_id' => $logoId,
            'url' => $url,
            'from_id' => $user->id,
            'to_id' => $this->toId,
        ];
        parent::__construct();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' .$this->toId);
    }
}
