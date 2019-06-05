<?php

namespace App\Observers;

use App\Models\Meeting;
use App\Services\Contracts\IMeetingService;
use App\Services\MeetingService;

/**
 * @property IMeetingService service
 */
class MeetingObserver
{
    public function __construct()
    {
        $this->service = app()->make(MeetingService::class);
    }

    /**
     * Handle the Meeting "created" Meeting.
     *
     * @param Meeting $meeting
     *
     * @return void
     */
    public function created(Meeting $meeting)
    {
        $this->service->sendMeetingNotice($meeting, 0);
    }


    /**
     * Handle the Meeting "updated" Meeting.
     *
     * @param Meeting $meeting
     *
     * @return void
     */
    public function updated(Meeting $meeting)
    {
        $this->service->sendMeetingNotice($meeting, 3);
    }

    /**
     * Handle the meeting "deleted" meeting.
     *
     * @param Meeting $meeting
     *
     * @return void
     */
    public function deleted(Meeting $meeting)
    {
        $this->service->sendMeetingNotice($meeting, 2);
    }

}
