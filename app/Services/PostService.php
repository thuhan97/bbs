<?php
/**
 * PostService class
 * Author: trinhnv
 * Date: 2018/11/11 13:59
 */

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Services\Contracts\IPostService;

class PostService extends AbstractService implements IPostService
{
    /**
     * PostService constructor.
     *
     * @param \App\Models\Post                            $model
     * @param \App\Repositories\Contracts\IPostRepository $repository
     */
    public function __construct(Post $model, IPostRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @param       $currentId
     * @param array $tagArrs
     *
     * @param int   $number
     *
     * @return mixed
     */
    public function getRelatePosts($currentId, array $tagArrs, $number = 10)
    {
        $models = $this->model->select(
            'id',
            'name',
            'slug_name',
            'image_url',
            'introduction'
        )
            ->where('status', ACTIVE_STATUS)
            ->where('id', '!=', $currentId)
            ->where(function ($q) use ($tagArrs) {
                foreach ($tagArrs as $tag) {
                    $q->orWhere(function ($p) use ($tag) {
                        $p->where('tags', $tag)
                            ->orWhere('tags', 'like', $tag . ',%')
                            ->orWhere('tags', 'like', '%,' . $tag)
                            ->orWhere('tags', 'like', '%,' . $tag . ',%');
                    });
                }
            })->orderBy('id', 'desc')
            ->limit($number);

        return $models->get();
    }
}
