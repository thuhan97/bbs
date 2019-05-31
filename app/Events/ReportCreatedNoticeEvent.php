<?php

namespace App\Events;

use App\Models\Report;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;

class ReportCreatedNoticeEvent extends NotificationBroadCast
{
    /**
     * @var User
     */
    private $receiver;

    /**
     * Create a new event instance.
     *
     * @param Report $report
     * @param User   $user
     */
    public function __construct(Report $report, User $receiver)
    {
        $senderName = $report->user->name;
        $url = route('report') . '?type=0#report_item_' . $report->id;
        $this->data = [
            'id' => $report->id,
            'title' => $senderName . ' gửi báo cáo công việc.',
            'content' => str_replace(': ' . $senderName, '', $report->title),
            'image_url' => $report->user->avatar,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['report']],
            'logo_id' => NOTIFICATION_TYPE['report'],
            'url' => $url,
            'from_id' => $report->user_id,
            'to_id' => $receiver->id,
        ];
        $this->receiver = $receiver;

        parent::__construct();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->receiver->id);
    }
}
