<?php
/**
 * EventAttendanceListService class
 * Author: jvb
 * Date: 2019/02/28 07:38
 */

namespace App\Services;

use App\Models\EventAttendanceList;
use App\Services\Contracts\IEventAttendanceListService;

class EventAttendanceListService extends AbstractService implements IEventAttendanceListService
{

    /**
     * PostService constructor.
     *
     * @param \App\Models\EventAttendanceList $model
     */
    public function __construct(EventAttendanceList $model)
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
        return EventAttendanceList::select('event_attendance_list.*', 'users.name', 'users.staff_code')
            ->join('users', 'event_attendance_list.user_id', '=', 'users.id')
            ->where('event_attendance_list.event_id', $id)->orderBy('users.id', 'asc')
            ->get();
    }
}
