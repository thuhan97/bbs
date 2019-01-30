<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $posts = Post::select('id', 'name', 'introduction', 'image_url')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $event = Event::select('id', 'name', 'place', 'event_date', 'introduction', 'image_url')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('id', 'desc')
            ->first();

        return view('end_user.home', compact('posts', 'event'));
    }


}
