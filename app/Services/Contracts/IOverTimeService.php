<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

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
     * @param Request $request
     * @param $explanationType
     * @return mixed
     */
    public function getListOverTime(Request $request,$explanationType);
}
