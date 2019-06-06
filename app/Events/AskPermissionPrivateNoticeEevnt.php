<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AskPermissionPrivateNoticeEevnt extends NotificationBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $toId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($datas, $type, $status)
    {
        $approverName = $datas->approver->name;
        if ($type == 'ot') {
            $url = route('ask_permission').'#ot-0';
            $this->toId = $datas->creator_id;
            $content = $datas->note_respond ?? '';
            if ($status == UNACTIVE_STATUS) {
                $logoId = NOTIFICATION_TYPE['close'];
                $logoUrld = NOTIFICATION_LOGO[NOTIFICATION_TYPE['close']];
                $title = $approverName . SPACE . __l('close_ot');

            } else {
                $logoId = NOTIFICATION_TYPE['active'];
                $logoUrld = NOTIFICATION_LOGO[NOTIFICATION_TYPE['active']];
                $title = $approverName . SPACE . __l('active_ot');
            }
        } else {
            $this->toId = $datas->user_id;
            $url = route('ask_permission');
            $this->toId = $datas->user_id;
            $content = $datas->reason_reject ?? '';
            if ($status == UNACTIVE_STATUS) {
                $logoId = NOTIFICATION_TYPE['close'];
                $logoUrld = NOTIFICATION_LOGO[NOTIFICATION_TYPE['close']];
                $title = $approverName . SPACE . __l('close_ask_soon');
                if ($datas->type == OT_TYPE_DEFAULT) {
                    $title = $approverName . SPACE . __l('close_ask_late');

                }
            } else {
                $title = $approverName . SPACE . __l('active_ask_soon');
                $logoId = NOTIFICATION_TYPE['active'];
                $logoUrld = NOTIFICATION_LOGO[NOTIFICATION_TYPE['active']];
                if ($datas->type == OT_TYPE_DEFAULT) {
                    $title = $approverName . SPACE . __l('active_ask_late');
                }
            }
        }
        $this->data = [
            'id' => $datas->id,
            'name' => $approverName,
            'title' => $title,
            'content' => $content,
            'image_url' => $datas->approver->avatar,
            'logo_url' => $logoUrld,
            'logo_id' => $logoId,
            'url' => $url,
            'from_id' => Auth::id(),
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
        return new PrivateChannel('users.' . $this->toId);
    }
}
