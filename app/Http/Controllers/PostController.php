<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IPostService;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * @var IPostService
     */
    private $service;

    public function __construct(IPostService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = $this->service->search($request, $perPage, $search);

        return view('end_user.post.index', compact('posts', 'search', 'perPage'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $post = $this->service->detail($id);

        if ($post) {
            return view('end_user.post.detail', compact('post'));
        }
        abort(404);
    }
}
