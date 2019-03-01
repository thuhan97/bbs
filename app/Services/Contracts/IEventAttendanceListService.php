<?php

namespace App\Services\Contracts;

/**
 * IEventAttendanceListService contract
 * Author: jvb
 * Date: 2019/02/28 07:38
 */
interface IEventAttendanceListService extends IBaseService
{
    /**
     * @param int $id
     *
     * @return Event
     */
    public function getListUserJoinEvent($id);
}
