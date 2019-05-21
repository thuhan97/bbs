<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCalendarRequest;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Services\Contracts\IEventAttendanceService;
use App\Services\Contracts\IEventService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use RESTActions;

    /**
     * @var IEventService
     * @var IEventAttendanceService
     * @var IEventAttendanceRepository
     */
    private $eventAttendanceRepository;
    private $eventService;
    private $eventAttendanceService;

    /**
     * EventController constructor.
     *
     * @param IEventService              $eventService
     * @param IEventAttendanceService    $eventAttendanceService
     * @param IEventAttendanceRepository $eventAttendanceRepository
     */
    public function __construct(
        IEventService $eventService,
        IEventAttendanceRepository $eventAttendanceRepository,
        IEventAttendanceService $eventAttendanceService
    )
    {
        $this->eventService = $eventService;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
        $this->eventAttendanceService = $eventAttendanceService;
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
            $userJoinEvent = $this->eventAttendanceRepository->getUserJoing(Auth::user()->id, $event->id);
            $listUserJoinEvent = $this->eventAttendanceService->getListUserJoinEvent($event->id);
            return view('end_user.event.detail', compact('event', 'userJoinEvent', 'listUserJoinEvent'));
        }
        abort(404);
    }
}
