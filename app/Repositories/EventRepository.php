<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Contracts\IEventRepository;

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
}
