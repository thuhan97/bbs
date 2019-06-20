<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Services\Contracts\IEventAttendanceService;
use App\Services\Contracts\IEventService;
use App\Traits\RESTActions;
use App\Transformers\EventAttendanceListTransformer;
use App\Transformers\EventTransformer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use RESTActions;

    /**
     * @var IEventService
     */
    private $eventService;
    /**
     * @var IEventAttendanceRepository
     */
    private $eventAttendanceRepository;
    /**
     * @var IEventAttendanceService
     */
    private $eventAttendanceService;

    /**
     * EventController constructor.
     *
     * @param IEventService              $eventService
     * @param IEventAttendanceRepository $eventAttendanceRepository
     * @param IEventAttendanceService    $eventAttendanceService
     * @param EventTransformer           $transformer
     */
    public function __construct(
        IEventService $eventService,
        IEventAttendanceRepository $eventAttendanceRepository,
        IEventAttendanceService $eventAttendanceService,
        EventTransformer $transformer
    )
    {
        $this->eventService = $eventService;
        $this->transformer = $transformer;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
        $this->eventAttendanceService = $eventAttendanceService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $events = $this->eventService->search($request, $perPage, $search);
        return $this->respondTransformer($events);
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
            return $this->respondTransformer($event, new EventAttendanceListTransformer(), 'event');
        }
        return $this->respondNotfound();
    }

}
