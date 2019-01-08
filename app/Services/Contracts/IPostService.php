<?php

namespace App\Services\Contracts;

/**
 * IPostService contract
 * Author: trinhnv
 * Date: 2018/11/11 13:59
 */
interface IPostService extends IBaseService
{
    /**
     * @param       $currentId
     * @param array $tagArrs
     *
     * @param int   $number
     *
     * @return mixed
     */
    public function getRelatePosts($currentId, array $tagArrs, $number = 10);
}
