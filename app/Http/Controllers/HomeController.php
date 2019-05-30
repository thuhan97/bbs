<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Project;
use App\Models\Punishes;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $posts = Post::select('id', 'name', 'introduction', 'image_url')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('updated_at', 'desc')
            ->take(2)
            ->get();

        $events = Event::select('id', 'name', 'place', 'event_date', 'event_end_date', 'introduction', 'image_url', 'content', 'created_at', 'deadline_at')
            ->where('status', ACTIVE_STATUS)
            ->whereDate('event_date', '>=', date(DATE_FORMAT))
            ->orderBy('event_date')
            ->take(3)->get();
        $projects = Project::select('id', 'name', 'technical', 'image_url')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $totalPunish = Punishes::whereDate('infringe_date', '>=', date('Y-m-01'))->sum('total_money');
        return view('end_user.home', compact('posts', 'events', 'projects', 'totalPunish'));
    }


}
