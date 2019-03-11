<?php

namespace App\Repositories\Contracts;

/**
 * EventAttendanceRepository contract.
 * Author: jvb
 * Date: 2019/03/11 09:35
 */
interface IEventAttendanceRepository extends IBaseRepository
{
    /**
     * Get User Joing
     * @author  Hunglt
     * @return object
     */
    public function getUserJoing($userId, $eventId);

}
