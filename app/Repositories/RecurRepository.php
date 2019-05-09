<?php

namespace App\Repositories;

use App\Models\Recur;
use App\Repositories\Contracts\IRecurRepository;
use Carbon\Carbon;

/**
 * EventRepository class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class RecurRepository extends AbstractRepository implements IRecurRepository
{
    /**
     * EventModel
     *
     * @var  string
     */
    protected $modelName = Recur::class;
    

}
