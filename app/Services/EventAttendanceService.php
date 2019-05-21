<?php
/**
 * EventAttendanceListService class
 * Author: jvb
 * Date: 2019/03/11 09:35
 */

namespace App\Services;

use App\Models\EventAttendance;
use App\Services\Contracts\IEventAttendanceService;

class EventAttendanceService extends AbstractService implements IEventAttendanceService
{
    /**
     * PostService constructor.
     *
     * @param \App\Models\EventAttendanceList $model
     */
    public function __construct(EventAttendance $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getListUserJoinEvent($id)
    {
        return EventAttendance::select('event_attendance.*', 'users.name', 'users.staff_code')
            ->join('users', 'event_attendance.user_id', '=', 'users.id')
            ->where('event_attendance.event_id', $id)
            ->orderBy('event_attendance.id', 'desc')
            ->get();
    }

}
