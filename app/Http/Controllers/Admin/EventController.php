<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Repositories\Contracts\IEventRepository;
use App\Services\Contracts\IEventService;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Services\Contracts\IEventAttendanceService;
use Illuminate\Support\Facades\Auth;
use App\Exports\DowloadExcelEventExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * EventController
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class EventController extends AdminBaseController
{
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
     * @param IEventService $eventService
     * @param IEventAttendanceService $eventAttendanceService
     * @param IEventAttendanceRepository $eventAttendanceRepository
     */


    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.events';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::events';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Event::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Sự kiện';

    /**
     * Controller construct
     */
    public function __construct(
        IEventRepository $repository, IEventService $eventService,
        IEventAttendanceRepository $eventAttendanceRepository,
        IEventAttendanceService $eventAttendanceService)
    {
        $this->repository = $repository;
        $this->eventService = $eventService;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
        $this->eventAttendanceService = $eventAttendanceService;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData();
    }

    private function validationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'image_url' => 'required|max:1000',
                'introduction' => 'required|max:500',
                'content' => 'required',
                'status' => 'required|numeric',
                'event_date' => 'required|date',
                'event_end_date' => 'date|after_or_equal:event_date',

            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function detailEvent($id)
    {
        $record = $this->repository->findOne($id);
        if ($record != null) {
            $listUserJoinEvent = $this->eventAttendanceService->getListUserJoinEvent($record->id);
            return view('admin.events.detail', compact('record', 'listUserJoinEvent'));
        }
        abort(404);
    }

    public function dowloadExcelListUserJoin($id)
    {
        $event = $this->repository->findOne($id);
        if (isset($event)) {
            $filename = $event->slug_name . XLS_TYPE;
            return Excel::download(new DowloadExcelEventExport($id), $filename);
        }
        abort(404);
    }

}
