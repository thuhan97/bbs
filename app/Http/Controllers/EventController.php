<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCalendarRequest;
use App\Services\Contracts\IEventService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use RESTActions;

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
    public function calendar(Request $request)
    {
        return view('end_user.event.calendar');
    }

    /**
     * @param EventCalendarRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCalendar(EventCalendarRequest $request)
    {
        $results = [];
        $events = $this->eventService->search_calendar($request);
        if ($events->isNotEmpty()) {
            foreach ($events as $event) {
                $results[] = [
                    'id' => $event->id,
                    'title' => $event->name,
                    'description' => $event->introduction,
                    'start' => $event->event_date,
                    'end' => $event->event_end_date
                ];
            }
        }

        return $this->respond(['events' => $results]);
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
