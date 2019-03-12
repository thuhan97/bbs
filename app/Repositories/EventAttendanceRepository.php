<?php

namespace App\Repositories;

use App\Models\EventAttendance;
use App\Repositories\Contracts\IEventAttendanceRepository;

/**
 * EventAttendanceRepository class
 * Author: jvb
 * Date: 2019/03/11 09:35
 */
class EventAttendanceRepository extends AbstractRepository implements IEventAttendanceRepository
{
    /**
     * EventAttendanceModel
     *
     * @var  string
     */
    protected $modelName = EventAttendance::class;

    /**
     * Get User Joing
     * @author  Hunglt
     * @return object
     */
    public function getUserJoing($userId, $eventId)
    {
        return EventAttendance::select('*')->where('user_id', $userId)->where('event_id', $eventId)->first();
    }

}
