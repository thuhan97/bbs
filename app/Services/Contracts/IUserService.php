<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * IUserService contract
 * Author: jvb
 * Date: 2018/07/16 10:34
 */
interface IUserService extends IBaseService
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function register(Request $request);

    /**
     * @param string $idCode
     *
     * @return int
     */
    public function getUserIdByIdCode(string $idCode);

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     * @param bool    $isGetAll
     *
     * @return collection
     */
    public function getContact(Request $request, &$perPage, &$search, $isGetAll = true);

    /**
     *
     * @return collection
     */
    public function getUserManager();

    public function detail($id);
}
