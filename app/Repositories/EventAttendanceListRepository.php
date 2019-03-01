<?php

namespace App\Repositories;

use App\Models\EventAttendanceList;
use App\Repositories\Contracts\IEventAttendanceListRepository;

/**
 * EventAttendanceListRepository class
 * Author: jvb
 * Date: 2019/02/28 07:38
 */
class EventAttendanceListRepository extends AbstractRepository implements IEventAttendanceListRepository
{
    /**
     * EventAttendanceListModel
     *
     * @var  string
     */
    protected $modelName = EventAttendanceList::class;

    /**
     * Get User Joing
     * @author  Hunglt
     * @return object
     */
    public function getUserJoing($userId, $eventId)
    {
        return EventAttendanceList::select('*')->where('user_id', $userId)->where('event_id', $eventId)->first();
    }
}
