<?php

namespace App\Repositories;

use App\Models\Statistics;
use App\Repositories\Contracts\IStatisticRepository;

/**
 * StatisticRepository class
 * User: jvb
 * Date: 4/4/2019
 */

class StatisticRepository extends AbstractRepository implements IStatisticRepository
{
    /**
     * WorkTimeModel
     *
     * @var  string
     */
    protected $modelName = Statistics::class;
}
