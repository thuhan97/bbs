<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Meeting;
use App\Models\MeetingRoom;
use App\Models\Team;
use App\Models\User;
use App\Repositories\Contracts\IBookingRepository;
use App\Services\Contracts\IMeetingService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class MeetingController extends Controller
{
    use RESTActions;

    protected $bookingService;
    protected $bookingRepository;

    public function __construct(IMeetingService $bookingService, IBookingRepository $bookingRepository)
    {
        $this->bookingService = $bookingService;
        $this->bookingRepository = $bookingRepository;
    }

    public function calendar()
    {
        $groups = $this->getUserTree();
        $meeting_rooms = MeetingRoom::all();
        return view('end_user.meeting.calendar', compact('meeting_rooms', 'groups'));
    }

    public function getCalendar(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $results1 = $this->bookingService->getMeetings($start, $end);

        $results2 = $this->bookingService->getBookings($start, $end);
        $results = array_merge($results1, $results2);

        return $this->respond(['bookings' => $results]);
    }

    public function booking(Request $request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'participants' => 'required',
            'meeting_room_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        $messages = [
            'required' => 'Vui lòng không để trống :attribute .',
        ];
        $attributes = [
            'title' => 'tiêu đề',
            'content' => 'nội dung',
            'participants' => 'đối tượng',
            'meeting_room_id' => 'phòng họp',
            'start_time' => 'thời gian bắt đầu',
            'end_time' => 'thời gian kết thúc',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors(), 'status' => 422], 200);

        } else {
            $meeting_room_id = $request->meeting_room_id;
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $days_repeat = $request->days_repeat;
            $check = $this->check($days_repeat, $meeting_room_id, $start_time, $end_time);
            if ($check == NO_DUPLICATE) {
                $date = $request->days_repeat;
                $data = [
                    'users_id' => \Auth::user()->id,
                    'title' => $request->title,
                    'content' => $request->get('content'),
                    'participants' => $request->participants,
                    'meeting_room_id' => $request->meeting_room_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'date' => $date,
                    'color' => $request->color,
                    'is_notify' => $request->is_notify,
                ];
                if ($request->repeat_type == NO_REPEAT) {
                    Meeting::insert($data);
                } else {
                    if ($request->repeat_type == YEARLY) {
                        $days_repeat = date('m-d', strtotime($request->days_repeat));
                    } else if ($request->repeat_type == MONTHLY) {
                        $days_repeat = (new \Carbon($request->days_repeat))->day;
                    } else if ($request->repeat_type == WEEKLY) {
                        $days_repeat = (new \Carbon($request->days_repeat))->dayOfWeek;
                    }
                    Meeting::insert($data);
                    $data['repeat_type'] = $request->repeat_type;
                    $data['days_repeat'] = $days_repeat;
                    Booking::insert($data);
                }
                return response()->json(["success" => true]);
            } else return response()->json(["duplicate" => true, 'status' => 500], 200);
        }

    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'participants' => 'required',
            'meeting_room_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        $messages = [
            'required' => 'Vui lòng không để trống :attribute .',
        ];
        $attributes = [
            'title' => 'tiêu đề',
            'content' => 'nội dung',
            'participants' => 'đối tượng',
            'meeting_room_id' => 'phòng họp',
            'start_time' => 'thời gian bắt đầu',
            'end_time' => 'thời gian kết thúc',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors(), 'status' => 422], 200);

        } else {
            $id = $request->id;
            $meeting_room_id = $request->meeting_room_id;
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $days_repeat = $request->days_repeat;
            $check = $this->check($days_repeat, $meeting_room_id, $start_time, $end_time, $id);
            if ($check == NO_DUPLICATE) {
                $date = $request->days_repeat;
                $data = [
                    'users_id' => \Auth::user()->id,
                    'title' => $request->title,
                    'content' => $request->get('content'),
                    'participants' => $request->participants,
                    'meeting_room_id' => $request->meeting_room_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'date' => $date,
                    'color' => $request->color,
                    'is_notify' => $request->is_notify,
                ];
                if ($request->repeat_type == NO_REPEAT) {

                    $booking = Meeting::where('id', $id)->update($data);

                } else {
                    if ($request->repeat_type == YEARLY) {
                        $days_repeat = date('m-d', strtotime($request->days_repeat));
                    } else if ($request->repeat_type == MONTHLY) {
                        $days_repeat = (new \Carbon($request->days_repeat))->day;
                    } else if ($request->repeat_type == WEEKLY) {
                        $days_repeat = (new \Carbon($request->days_repeat))->dayOfWeek;
                    }
                    $data['repeat_type'] = $request->repeat_type;
                    $data['days_repeat'] = $days_repeat;
                    $booking = Booking::where('id', $id)->update($data);
                }
                return response()->json(["success" => true]);
            } else return response()->json(["duplicate" => true, 'status' => 500], 200);
        }
    }

    public function getMeeting(Request $request)
    {
        $id = $request->id;
        $meeting_room_id = $request->meeting_room_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $date = $request->date;
        $condition1 = [
            'id' => $id,
            'meeting_room_id' => $meeting_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'date' => $date
        ];
        $condition2 = [
            'id' => $id,
            'meeting_room_id' => $meeting_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
        $booking = (count(Meeting::where($condition1)->get()) > 0) ? (Meeting::where($condition1)->first()) : (Booking::where($condition2)->first());
        $participants = explode(",", $booking->participants);
        $objects = [];
        foreach ($participants as $user_id) {
            $objects[] = (User::find($user_id))->name;
        }
        $meeting = MeetingRoom::find($meeting_room_id)->name;
        return response()->json(["booking" => $booking, "participants" => $objects, "meeting" => $meeting]);
    }

    public function deleteMeeting(Request $request)
    {
        $id = $request->id;
        $meeting_room_id = $request->meeting_room_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $date = $request->date;
        $condition1 = [
            'id' => $id,
            'meeting_room_id' => $meeting_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'date' => $date
        ];
        $condition2 = [
            'id' => $id,
            'meeting_room_id' => $meeting_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
        $booking = (count(Meeting::where($condition1)->get()) > 0) ? (Meeting::where($condition1)->first()) : (Booking::where($condition2)->first());
        $booking->delete();
        return response()->json(["messages" => "success"]);
    }

    public function check($days_repeat, $meeting_room_id, $start_time, $end_time, $id = null)
    {
        $date = $days_repeat;
        $date_month = date('m-d', strtotime($days_repeat));
        $day = (new \Carbon($days_repeat))->day;
        $dayOfWeek = (new \Carbon($days_repeat))->dayOfWeek;

        $check = NO_DUPLICATE;

        $booking_default = [['id', '<>', $id], ['meeting_room_id', $meeting_room_id]];

        // check theo lich khong lap
        $booking = [];
        $model = new Meeting();
        $booking[0] = $model->where('date', $date)->where($booking_default);
        $model = Booking::where($booking_default);
        // check lich tuan
        $booking[1] = clone $model->where('repeat_type', WEEKLY)->where('days_repeat', $dayOfWeek);

        //check lich theo thang
        $booking[2] = clone $model->where('repeat_type', MONTHLY)->where('days_repeat', $day);

        //check lich theo nam
        $booking[3] = clone $model->where('repeat_type', YEARLY)->where('days_repeat', $date_month);

        for ($i = 0; $i < 4; $i++) {
            $bookings = $booking[$i];
            if (count($bookings->get()) > 0) {
                $bookings = $bookings->where(function ($q) use ($start_time, $end_time) {
                    $q->where('start_time', '>=', $end_time)->orWhere('end_time', '<=', $start_time);
                })->get();
                if (count($bookings) > 0) $check = NO_DUPLICATE;
                else {
                    $check = DUPLICATE;
                    return $check;
                }
            } else $check = NO_DUPLICATE;
        }
        return $check;
    }


    private function getUserTree()
    {
        $results = [];
        $jobtitles = [];
        foreach (array_reverse(JOB_TITLES) as $value => $name) {
            $jobtitles['J-' . $value] = $name;
        }
        $results['Chức danh'] = $jobtitles;
        $positions = [];
        foreach (POSITIONS as $value => $name) {
            $positions['P-' . $value] = $name;
        }
        $results['Chức vụ'] = $positions;

        $teams = Team::select('teams.id', DB::raw("CONCAT(groups.name, ' - ', teams.name) as name"))
            ->join('groups', 'groups.id', 'teams.group_id')
            ->orderBy('groups.name')
            ->pluck('name', 'id')->toArray();

        $results['Teams'] = $teams;

        $users = User::select('id', DB::raw('CONCAT(staff_code, " - ", name) as name'))->where('status', ACTIVE_STATUS)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name', 'id')->toArray();
        $results['Danh sách nhân viên'] = $users;

        return $results;
    }
}
