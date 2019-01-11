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
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search)
    {
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        return $this->repository->findBy($criterias, [
            'id',
            'name',
            'slug_name',
            'tags',
            'introduction',
            'created_at',
        ]);
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function detail($id)
    {
        $post = $this->repository->findOneBy([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ]);

        if ($post) {
            $post->view_count++;
            $post->save();
            return $post;
        }
    }
}
