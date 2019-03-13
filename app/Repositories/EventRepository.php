<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Contracts\IEventRepository;
use Carbon\Carbon;

/**
 * EventRepository class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class EventRepository extends AbstractRepository implements IEventRepository
{
    /**
     * EventModel
     *
     * @var  string
     */
    protected $modelName = Event::class;

    /**
     * find Event Date Push Notification
     * @author  Hunglt
     * @return object
     */
    public function findEventDatePushNotification()
    {
        return Event::select('*')->whereDate('notify_date', Carbon::today())->where('is_sent', 0)->get();
    }
}
