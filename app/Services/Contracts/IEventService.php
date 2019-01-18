<?php

namespace App\Services\Contracts;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * IEventService contract
 * Author: trinhnv
 * Date: 2018/10/07 16:46
 */
interface IEventService extends IBaseService
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
     *
     * @return collection
     */
    public function search_calendar(Request $request);

    /**
     * @param int $id
     *
     * @return Event
     */
    public function detail($id);
}
