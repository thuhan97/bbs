<?php
namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: vanho
 * Date: 4/4/2019
 * Time: 3:14 PM
 */

interface IStatisticService extends IBaseService
{
    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search);
}