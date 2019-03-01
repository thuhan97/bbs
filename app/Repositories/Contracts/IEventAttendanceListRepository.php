<?php

namespace App\Repositories\Contracts;

/**
 * EventAttendanceListRepository contract.
 * Author: jvb
 * Date: 2019/02/28 07:38
 */
interface IEventAttendanceListRepository extends IBaseRepository
{
    /**
     * Get User Joing
     * @author  Hunglt
     * @return object
     */
    public function getUserJoing($userId, $eventId);

}
