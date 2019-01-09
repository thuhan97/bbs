<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IPostRepository;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(IPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return view('end_user.post.index');
    }
}
