<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IEventAttendanceListService;
use App\Repositories\Contracts\IEventAttendanceListRepository;
use App\Repositories\Contracts\IEventRepository;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventAttendanceListController extends Controller
{
    use RESTActions;

    /**
     * @var IEventAttendanceListService
     */
    private $eventAttendanceListService;

    /**
     * @var IEventAttendanceListRepository
     * @var IEventRepository
     */
    private $eventAttendanceListRepository;
    private $eventRepository;

    /**
     * EventAttendanceListController constructor.
     *
     * @param IEventAttendanceListService $eventAttendanceListService
     * @param IEventAttendanceListRepository $eventAttendanceListRepository
     * @param IEventRepository $eventRepository
     */


    public function __construct(
        IEventAttendanceListService $eventAttendanceListService,
        IEventAttendanceListRepository $eventAttendanceListRepository,
        IEventRepository $eventRepository
    )
    {
        $this->eventAttendanceListService = $eventAttendanceListService;
        $this->eventAttendanceListRepository = $eventAttendanceListRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function JoinEvent(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($data['deadline_at'] < date('Y-m-d H:i:s')) {
            return redirect(route('event_detail', ['id' => $data['event_id']]))->with('message', __('Đã hết hạn gửi phản hồi'));
        } else {
            $oldJoinEvent = $this->eventAttendanceListRepository->getUserJoing($data['user_id'], $data['event_id']);
            if ($oldJoinEvent != null) {
                $oldJoinEvent->content = $data['content'];
                $oldJoinEvent->status = $data['status'];
                $oldJoinEvent->save();
            } else {
                $this->eventAttendanceListRepository->save($data);
            }
            return redirect(route('event_detail', ['id' => $data['event_id']]))->with('message', __('Gửi phàn hồi thành công'));
        }

    }

}
