<?php

namespace App\Repositories;

use App\Models\OverTime;
use App\Repositories\Contracts\IOverTimeRepository;

/**
 * OverTimeRepository class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class OverTimeRepository extends AbstractRepository implements IOverTimeRepository
{
    /**
     * OverTimeModel
     *
     * @var  string
     */
    protected $modelName = OverTime::class;
}
