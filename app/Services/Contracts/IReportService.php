<?php

namespace App\Services\Contracts;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * IReportService contract
 * Author: trinhnv
 * Date: 2019/01/21 03:42
 */
interface IReportService extends IBaseService
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
     * @param int $id
     *
     * @return Report
     */
    public function detail($id);

    /**
     * @return Report
     */
    public function newReportFromTemplate();
}
