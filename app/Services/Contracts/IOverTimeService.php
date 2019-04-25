<?php

namespace App\Services\Contracts;

/**
 * IOverTimeService contract
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
interface IOverTimeService extends IBaseService
{
    /**
     * get over time list
     *
     * @return mixed
     */
    public function getListOverTime();
}
