<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCalendarRequest;
use App\Services\Contracts\IEventService;
use App\Repositories\Contracts\IEventAttendanceListRepository;
use App\Services\Contracts\IEventAttendanceListService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use RESTActions;

    /**
     * @var IEventService
     * @var IEventAttendanceListService
     * @var IEventAttendanceListRepository
     */
    private $eventAttendanceListRepository;
    private $eventService;
    private $eventAttendanceListService;

    /**
     * EventController constructor.
     *
     * @param IEventService $eventService
     * @param IEventAttendanceListService $eventAttendanceListService
     * @param IEventAttendanceListRepository $eventAttendanceListRepository
     */
    public function __construct(
        IEventService $eventService,
        IEventAttendanceListRepository $eventAttendanceListRepository,
        IEventAttendanceListService $eventAttendanceListService
    )
    {
        $this->eventService = $eventService;
        $this->eventAttendanceListRepository = $eventAttendanceListRepository;
        $this->eventAttendanceListService = $eventAttendanceListService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function index(Request $request)
    {
        $events = $this->eventService->search($request, $perPage, $search);

        return view('end_user.event.index', compact('events', 'search', 'perPage'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function calendar(Request $request)
    {
        return view('end_user.event.calendar');
    }

    /**
     * @param EventCalendarRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function getCalendar(EventCalendarRequest $request)
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
        if ($event != null) {
            $userJoinEvent = $this->eventAttendanceListRepository->getUserJoing(Auth::user()->id, $event->id);
            $listUserJoinEvent = $this->eventAttendanceListService->getListUserJoinEvent($event->id);
//            dd($listUserJoinEvent);
            return view('end_user.event.detail', compact('event', 'userJoinEvent', 'listUserJoinEvent'));
        }
        abort(404);
    }
}
