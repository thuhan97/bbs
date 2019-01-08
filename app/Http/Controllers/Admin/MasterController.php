<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;

/**
 * AdminController
 * Author: trinhnv
 * Date: 2018/09/03 01:52
 */
class MasterController extends Controller
{
    /**
     * Controller construct
     */
    public function __construct()
    {
    }

    public function index()
    {
        $postCount = Post::count();
        $eventCount = Event::count();
        $userCount = User::count();

        return view('admin.master', compact('postCount', 'eventCount', 'userCount'));
    }

}
