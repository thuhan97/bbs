<?php

namespace App\Events;

use App\Models\Report;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportCreatedNoticeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Report
     */
    public $report;

    /**
     * @var User
     */
    public $receiver;

    /**
     * Create a new event instance.
     *
     * @param Report $report
     * @param User   $user
     */
    public function __construct(Report $report, User $receiver)
    {
        $this->report = $report;
        $this->receiver = $receiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel($this->receiver->id . ' _report_sent');
    }
}
