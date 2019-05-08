<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Project;

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
            ->take(2)
            ->get();

        $event = Event::select('id', 'name', 'place', 'event_date', 'event_end_date', 'introduction', 'image_url', 'content', 'created_at')
            ->where('status', ACTIVE_STATUS)
            ->whereDate('event_date', '>=', date(DATE_FORMAT))
            ->orderBy('event_date')
            ->first();


        $projects = Project::select('id', 'name', 'technical', 'image_url')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('end_user.home', compact('posts', 'event', 'projects'));
    }


}
