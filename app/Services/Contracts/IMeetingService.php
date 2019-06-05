<?php

namespace App\Services\Contracts;

use App\Models\Meeting;
use Illuminate\Support\Collection;


interface IMeetingService extends IBaseService
{


    /**
     * @param $start , $end
     *
     * @return collection
     */
    public function getMeetings($start, $end);

    public function getBookings($start, $end);

    /**
     * @param $meeting
     *
     * @return array
     */
    public function getParticipantIds($meeting);

    /**
     * @param int $id
     *
     * @return Meeting
     */
    public function detail($id);

    /**
     * @return mixed
     */
    public function getUserTree();

    /**
     * @param Meeting $meeting
     * @param int     $type
     *
     * @return mixed
     */
    public function sendMeetingNotice(Meeting $meeting, $type = 0);

}
