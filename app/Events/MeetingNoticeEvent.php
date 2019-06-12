<?php

namespace App\Events;

use App\Helpers\NotificationHelper;
use App\Models\Meeting;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MeetingNoticeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting, $userIds, $type)
    {
        $url = route('meetings', ['id' => $meeting->id]);
        $title = $this->getTitle($meeting, $type);
        $content = $meeting->title;
        $receiverUserIds = [];
        foreach ($userIds as $user_id) {
            if ($meeting->user_id == $user_id) continue;
            $receiverUserIds[] = $user_id;
            $notifications[] =
                NotificationHelper::generateNotify($user_id, $title, $content, Auth::id(), NOTIFICATION_TYPE['meeting'], $url);
        }

        Notification::insertAll($notifications);
        $this->data = [
            'id' => $meeting->id,
            'title' => $title,
            'content' => $content,
            'image_url' => Auth::user()->avatar,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['meeting']],
            'logo_id' => NOTIFICATION_TYPE['meeting'],
            'url' => $url,
            'user_ids' => $receiverUserIds,
        ];
    }

    private function getTitle($meeting, $type)
    {
        $userName = $meeting->creator->name ?? 'BBS';
        switch ($type) {
            case 0:
                $action = 'tạo';
                break;
            case 1:
                $action = 'cập nhật';
                break;
            case 2:
                $action = 'hủy';
                break;
            default:
                return 'Thông báo lịch họp';
                break;
        }

        return "$userName đã $action lịch họp";
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
