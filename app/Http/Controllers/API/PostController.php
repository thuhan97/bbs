<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IPostService;
use App\Traits\RESTActions;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use RESTActions;

    /**
     * @var IPostService
     */
    private $postService;

    /**
     * PostController constructor.
     *
     * @param IPostService    $postService
     * @param PostTransformer $transformer
     */
    public function __construct(
        IPostService $postService,
        PostTransformer $transformer
    )
    {
        $this->postService = $postService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = $this->postService->search($request, $perPage, $search);
        return $this->respondTransformer($posts);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $post = $this->postService->detail($id);
        if ($post != null) {
            return $this->respondTransformer($post);
        }
        return $this->respondNotfound();
    }

}
