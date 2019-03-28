<?php

namespace App\Services\Contracts;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * IProjectService contract
 * Author: jvb
 * Date: 2019/01/31 05:00
 */
interface IProjectService extends IBaseService
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
     * @return Project
     */
    public function detail($id);
}
