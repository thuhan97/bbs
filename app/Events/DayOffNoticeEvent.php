<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DayOffNoticeEvent extends NotificationBroadCast
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
    public function __construct($dayoff,$user,$type)
    {
        $url = route('day_off'). "#$dayoff->id";
        $this->toId = $dayoff->user_id;
        $content=$dayoff->approve_comment ?? $dayoff->reason;
        if ($type == NOTIFICATION_DAY_OFF['create']){
            $vacation=mb_strtolower(VACATION_FULL[$dayoff->title],'UTF-8');
            $title = $user->name .SPACE.__l('day_off').SPACE.$vacation;
            $url = route('day_off_approval'). "#$dayoff->id";
            $this->toId = $dayoff->approver_id;
            $id=$dayoff->approver_id;
            $content=$dayoff->reason ?? '';
            $logoId=NOTIFICATION_TYPE['day_off_create'];
            $logoUrld=NOTIFICATION_LOGO[NOTIFICATION_TYPE['day_off_create']];
        }elseif ($type == NOTIFICATION_DAY_OFF['active']){
            $title = $user->name .__l('notify_active_day_off');
            $logoId=NOTIFICATION_TYPE['active'];
            $logoUrld=NOTIFICATION_LOGO[NOTIFICATION_TYPE['active']];
        }else{
            $title = $user->name .__l('notify_close_day_off');
            $logoId=NOTIFICATION_TYPE['close'];
            $logoUrld=NOTIFICATION_LOGO[NOTIFICATION_TYPE['close']];
        }
        $this->data = [
            'id' =>  $dayoff->id,
            'name' => $user->name,
            'title' => $title,
            'content' => $content,
            'image_url' => $user->avatar,
            'logo_url' => $logoUrld,
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
