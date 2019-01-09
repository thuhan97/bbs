<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IEventRepository;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(IEventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        return view('end_user.event.index');
    }
}
