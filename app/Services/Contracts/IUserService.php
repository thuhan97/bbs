<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

/**
 * IUserService contract
 * Author: trinhnv
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
     * activate
     *
     * @param $data
     *
     * @return bool
     */
    public function active($data);

    /**
     * get total potato
     *
     * @param $user_id
     *
     * @return int
     */
    public function getPotato($user_id);
}
