<?php

namespace App\Repositories\Contracts;

/**
 * EventRepository contract.
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
interface IEventRepository extends IBaseRepository
{
    /**
     * find Event Date Push Notification
     * @author  Hunglt
     * @return object
     */
    public function findEventDatePushNotification();
}
