<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IEventService;
use App\Traits\RESTActions;
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
     * EventController constructor.
     *
     * @param IEventService    $eventService
     * @param EventTransformer $transformer
     */
    public function __construct(
        IEventService $eventService,
        EventTransformer $transformer
    )
    {
        $this->eventService = $eventService;
        $this->transformer = $transformer;
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

}
