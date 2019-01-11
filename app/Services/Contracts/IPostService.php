<?php

namespace App\Services\Contracts;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
     * @return Post
     */
    public function detail($id);
}
