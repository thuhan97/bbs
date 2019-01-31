<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

/**
 * IDayOffService contract
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
interface IDayOffService extends IBaseService
{
    /**
     * @param Request $request
     * @param array   $moreConditions
     * @param array   $fields
     * @param string  $search
     * @param int     $perPage
     *
     * @return mixed
     */
    public function findList(Request $request, $moreConditions = [], $fields = ['*'], &$search = '', &$perPage = DEFAULT_PAGE_SIZE);

    /**
     * @param $userId
     *
     * @return array
     */
    public function getDayOffUser($userId);

    public function updateStatusDayOff($recordID, $approvalID, $comment);
}
