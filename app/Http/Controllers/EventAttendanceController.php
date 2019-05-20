<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Repositories\Contracts\IEventRepository;
use App\Services\Contracts\IEventAttendanceService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventAttendanceController extends Controller
{
    use RESTActions;

    /**
     * @var IEventAttendanceService
     */
    private $eventAttendanceService;

    /**
     * @var IEventAttendanceRepository
     * @var IEventRepository
     */
    private $eventAttendanceRepository;
    private $eventRepository;

    /**
     * EventAttendanceController constructor.
     *
     * @param IEventAttendanceService    $eventAttendanceService
     * @param IEventAttendanceRepository $eventAttendanceRepository
     * @param IEventRepository           $eventRepository
     */


    public function __construct(
        IEventAttendanceService $eventAttendanceService,
        IEventAttendanceRepository $eventAttendanceRepository,
        IEventRepository $eventRepository
    )
    {
        $this->eventAttendanceService = $eventAttendanceService;
        $this->eventAttendanceRepository = $eventAttendanceRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function joinEvent(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($data['deadline_at'] < date('Y-m-d H:i:s')) {
            return redirect(route('event_detail', ['id' => $data['event_id']]))->with('message', 'Hết thời gian đăng ký tham gia sự kiện');
        } else {
            $oldJoinEvent = $this->eventAttendanceRepository->getUserJoing($data['user_id'], $data['event_id']);
            if ($oldJoinEvent != null) {
                $oldJoinEvent->content = $data['content'];
                $oldJoinEvent->status = $data['status'];
                $oldJoinEvent->save();
            } else {
                $this->eventAttendanceRepository->save($data);
            }
            return redirect(route('event_detail', ['id' => $data['event_id']]))->with('message', 'Đã đăng ký thành công');
        }

    }

    public function quickJoinEvent(Request $request, $id)
    {
        $data = $request->all();

        $userId = Auth::user()->id;
        $event = Event::find($id);
        if ($event) {
            if ($event['deadline_at'] < date(DATE_TIME_FORMAT)) {
                return redirect(route('event_detail', ['id' => $id]))->with('message', 'Hết thời gian đăng ký tham gia sự kiện');
            } else {
                $oldJoinEvent = $this->eventAttendanceRepository->getUserJoing($userId, $id);
                if ($oldJoinEvent != null) {
                    $oldJoinEvent->status = EVENT_JOIN_STATUS;
                    $oldJoinEvent->save();
                } else {
                    $data['user_id'] = $userId;
                    $data['event_id'] = $id;
                    $data['status'] = EVENT_JOIN_STATUS;

                    $this->eventAttendanceRepository->save($data);
                }
                return redirect(route('event_detail', ['id' => $id]) . '#registerList')->with('message', 'Đã đăng ký thành công');
            }
        }
        //registerList
        abort(404);
    }

}
