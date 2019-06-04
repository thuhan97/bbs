<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;

class ReportReplyNoticeEvent extends NotificationBroadCast
{
    private $toId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sender, $toId, $report, $replyContent)
    {
        $reportId = $report->id;
        $year = $report->year;
        $month = $report->month;
        $url = route('report') . "?type=1&year=$year&month=$month#report_item_$reportId";

        $this->data = [
            'id' => $reportId,
            'name' => $sender->name,
            'title' => $sender->name . ' trả lời báo cáo.',
            'content' => $replyContent,
            'image_url' => $sender->avatar,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['comment_report']],
            'logo_id' => NOTIFICATION_TYPE['comment_report'],
            'url' => $url,
            'from_id' => $sender->id,
            'to_id' => $toId,
        ];

        parent::__construct();

        $this->toId = $toId;
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
