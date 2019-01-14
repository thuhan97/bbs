<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IEventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @var IEventService
     */
    private $eventService;

    /**
     * EventController constructor.
     *
     * @param IEventService $eventService
     */
    public function __construct(IEventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $events = $this->eventService->search($request, $perPage, $search);

        return view('end_user.event.index', compact('events', 'search', 'perPage'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calender(Request $request)
    {
        $request->merge(['page_size' => 1000]);
        $events = $this->eventService->search($request, $perPage, $search);

        return view('end_user.event.calendar', compact('events', 'search', 'perPage'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $event = $this->eventService->detail($id);

        if ($event) {
            return view('end_user.event.detail', compact('event'));
        }
        abort(404);
    }
}
