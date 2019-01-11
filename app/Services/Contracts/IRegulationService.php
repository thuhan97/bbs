<?php

namespace App\Services\Contracts;

use App\Models\Regulation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * IRegulationService contract
 * Author: trinhnv
 * Date: 2019/01/11 09:23
 */
interface IRegulationService extends IBaseService
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
     * @return Regulation
     */
    public function detail($id);
}
