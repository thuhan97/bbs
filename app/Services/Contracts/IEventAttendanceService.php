<?php

namespace App\Services\Contracts;

/**
 * IEventAttendanceService contract
 * Author: jvb
 * Date: 2019/03/11 09:35
 */
interface IEventAttendanceService extends IBaseService
{
    /**
     * @param int $id
     *
     * @return Event
     */
    public function getListUserJoinEvent($id);

}
