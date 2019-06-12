<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingMeetingRequest;
use App\Models\Booking;
use App\Models\Meeting;
use App\Models\MeetingRoom;
use App\Models\User;
use App\Services\Contracts\IMeetingService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class MeetingController extends Controller
{
    use RESTActions;

    protected $meetingService;

    public function __construct(IMeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function calendar()
    {
        $groups = $this->meetingService->getUserTree();
        $meeting_rooms = MeetingRoom::all();
        return view('end_user.meeting.calendar', compact('meeting_rooms', 'groups'));
    }

    public function getCalendar(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $results1 = $this->meetingService->getMeetings($start, $end);

        $results2 = $this->meetingService->getBookings($start, $end);
        $results = array_merge($results1, $results2);

        return $this->respond(['bookings' => $results]);
    }

    public function booking(Request $request)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors(), 'status' => 422], 200);
        }
        $meeting_room_id = $request->meeting_room_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $days_repeat = $request->days_repeat;

        $check = $this->check($days_repeat, $meeting_room_id, $start_time, $end_time);

        if ($check == NO_DUPLICATE) {
            $room = MeetingRoom::find($meeting_room_id);
            DB::beginTransaction();
            $date = $request->days_repeat;
            $data = [
                'users_id' => \Auth::user()->id,
                'title' => $request->title,
                'participants' => implode(',', $request->participants),
                'content' => $request->get('content'),
                'meeting_room_id' => $meeting_room_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $date,
                'color' => $room->color,
                'is_notify' => $request->is_notify,
            ];

            $meeting = new Meeting();
            if ($request->repeat_type == NO_REPEAT) {
                $meeting->fill($data);

                $meeting->save();
            } else {
                if ($request->repeat_type == YEARLY) {
                    $days_repeat = date('m-d', strtotime($request->days_repeat));
                } else if ($request->repeat_type == MONTHLY) {
                    $days_repeat = (new \Carbon($request->days_repeat))->day;
                } else if ($request->repeat_type == WEEKLY) {
                    $days_repeat = (new \Carbon($request->days_repeat))->dayOfWeek;
                }
                $meeting->fill($data);
                $meeting->save();
                $data['repeat_type'] = $request->repeat_type;
                $data['days_repeat'] = $days_repeat;
                $data['meeting_id'] = $meeting->id;
                Booking::insert($data);
            }

            DB::commit();
            return response()->json(["success" => true]);
        } else return response()->json(["duplicate" => true, 'status' => 500], 200);
    }

    public function update(Request $request, $id)
    {
        $booking = Meeting::find($id) ?? Booking::where('meeting_id', $id)->first();
        if ($booking->users_id != Auth::id()) {
            return response()->json(["unauthorized" => true, 'status' => 500], 200);
        }
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors(), 'status' => 422], 200);
        }
        $meeting_room_id = $request->meeting_room_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $days_repeat = $request->days_repeat;
        $check = $this->check($days_repeat, $meeting_room_id, $start_time, $end_time, $id);

        if ($check == NO_DUPLICATE) {
            $date = $request->days_repeat;

            $data = [
                'title' => $request->title,
                'content' => $request->get('content'),
                'participants' => implode(',', $request->participants),
                'meeting_room_id' => $request->meeting_room_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $date,
                'color' => $request->color,
                'is_notify' => $request->is_notify,
            ];

            Meeting::where('id', $id)->update($data);
            if ($request->repeat_type == NO_REPEAT) {
                Booking::where('meeting_id', $id)->delete();
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
                $data['deleted_at'] = null;

                Booking::where('meeting_id', $id)->withTrashed()->update($data);
            }
            return response()->json(["success" => true]);
        } else return response()->json(["duplicate" => true, 'status' => 500], 200);
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
//            'meeting_room_id' => $meeting_room_id,
//            'start_time' => $start_time,
//            'end_time' => $end_time,
//            'date' => $date
        ];
        $condition2 = [
            'id' => $id,
            'meeting_room_id' => $meeting_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];

        $booking = Meeting::where($condition1)->with('creator:id,name')->first() ?? Booking::where($condition2)->with('creator:id,name')->first();

        if ($booking) {
            $participantIds = $this->meetingService->getParticipantIds($booking);
            $users = User::whereIn('id', $participantIds)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name')->toArray();
            $meeting = MeetingRoom::find($meeting_room_id)->name;
            return response()->json(["booking" => $booking, "participants" => $users, "meeting" => $meeting]);
        }
    }

    public function deleteMeeting(Request $request)
    {
        $id = $request->id;

        $meeting = Meeting::find($id);
        if ($meeting) {
            Booking::where('meeting_id', $id)->forceDelete();
            $meeting->delete();
            return response()->json(["messages" => "success"]);
        }
        return response()->json(["messages" => "failed"]);
    }

    public function check($days_repeat, $meeting_room_id, $start_time, $end_time, $id = null)
    {
        $date = $days_repeat;
        $date_month = date('m-d', strtotime($days_repeat));
        $day = (new \Carbon($days_repeat))->day;
        $dayOfWeek = (new \Carbon($days_repeat))->dayOfWeek;

        $check = NO_DUPLICATE;

        $meeting_default = [['id', '<>', $id], ['meeting_room_id', $meeting_room_id]];
        $booking_default = [['meeting_id', '<>', $id], ['meeting_room_id', $meeting_room_id]];

        // check theo lich khong lap
        $booking = [];
        $meetingModel = new Meeting();
        $booking[0] = $meetingModel->where('date', $date)->where($meeting_default);
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

    private function validateRequest(Request $request)
    {
        $validateRequest = new BookingMeetingRequest();
        $validator = Validator::make($request->all(), $validateRequest->rules(), $validateRequest->messages(), $validateRequest->attributes());
        return $validator;
    }

}
