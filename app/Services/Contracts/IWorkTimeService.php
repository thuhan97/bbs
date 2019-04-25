<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * IWorkTimeService contract
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
interface IWorkTimeService extends IBaseService
{
    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search);

    /**
     * @param Request $request
     * @param         $search
     *
     * @return mixed
     */
    public function export(Request $request);

    /**
     * @param       $fromDate
     * @param       $toDate
     * @param array $userIds
     *
     * @return mixed
     */
    public function calculateLateTime($fromDate, $toDate, $userIds = []);
}
