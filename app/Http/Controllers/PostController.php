<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IPostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(IPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        $posts = $this->postRepository->findBy($criterias, [
            'id',
            'name',
            'slug_name',
            'tags',
            'introduction',
            'created_at',
        ]);

        return view('end_user.post.index', compact('posts', 'search', 'perPage'));
    }

    public function detail($id)
    {
        $post = $this->postRepository->findOneBy([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ]);

        if ($post) {
            $post->view_count++;
            $post->save();
            return view('end_user.post.detail', compact('post'));
        }
        abort(404);
    }
}
