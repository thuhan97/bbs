<?php
/**
 * EventService class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */

namespace App\Services;

use App\Events\MeetingNoticeEvent;
use App\Events\ReportNoticeEvent;
use App\Models\Booking;
use App\Models\Meeting;
use App\Models\Team;
use App\Models\User;
use App\Models\UserTeam;
use App\Services\Contracts\IMeetingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeetingService extends AbstractService implements IMeetingService
{
    const HAS_MEETING_COLOR = 'red';

    /**
     * MeetingService constructor.
     *
     */
    public function __construct()
    {

    }


    /**
     * @param int $id
     *
     * @return Meeting
     */
    public function detail($id)
    {
        return Meeting::find($id);
    }

    /**
     * @param $start
     * @param $end
     *
     * @return array
     */

    public function getMeetings($start, $end)
    {
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        $results = [];
        $bookings = Meeting::where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->get();
        if ($bookings->isNotEmpty()) {
            foreach ($bookings as $booking) {
                $inMeeting = in_array(Auth::id(), $this->getParticipantIds($booking));
                $item = [
                    'id' => $booking->id,
                    'user_id' => $booking->users_id,
                    'editable' => Auth::id() == $booking->users_id,
                    'title' => $booking->title,
                    'description' => $booking->meeting_room_id,
                    'start' => $booking->date . ' ' . $booking->start_time,
                    'end' => $booking->date . ' ' . $booking->end_time,
                    'textColor' => '#fff',
                    'color' => $booking->color,
                    'has_me' => $inMeeting,
                ];

                if ($inMeeting)
                    $item['borderColor'] = self::HAS_MEETING_COLOR;
                $results[] = $item;
            }
        }
        return $results;
    }

    /**
     * @param $start
     * @param $end
     *
     * @return array
     */
    public function getBookings($start, $end)
    {
        $end = date('Y-m-d', strtotime($end));
        $results = [];
        $bookings = Booking::where('date', '<=', $end)->get();
        foreach ($bookings as $booking) {
            $startDate = null;
            $days_repeat = $booking->days_repeat;
            if ($booking->repeat_type == WEEKLY) {
                $startDate = date('Y-m-d', strtotime($start . ' + ' . $days_repeat . ' days'));
            } elseif ($booking->repeat_type == MONTHLY) {

                $day = $this->getDateOfRecurMonthly($start, $end, $days_repeat);
                if ($day != null) {
                    $startDate = $day;
                }
            } else if ($booking->repeat_type == YEARLY) {
                $day = $this->getDateOfRecurYearly($start, $end, $days_repeat);
                if ($day !== null)
                    $startDate = $day;
            } else {
                $startDate = $booking->days_repeat;

            }
            if ($startDate != null && $startDate > $booking->date && $startDate > Carbon::now()->format('Y-m-d')) {
                $inMeeting = in_array(Auth::id(), $this->getParticipantIds($booking));
                $item = [
                    'id' => $booking->id,
                    'user_id' => $booking->users_id,
                    'editable' => Auth::id() == $booking->users_id,
                    'title' => $booking->title,
                    'description' => $booking->meeting_room_id,
                    'start' => $startDate . ' ' . $booking->start_time,
                    'end' => $startDate . ' ' . $booking->end_time,
                    'textColor' => '#fff',
                    'color' => $booking->color,
                    'has_me' => $inMeeting,
                ];
                if ($inMeeting)
                    $item['borderColor'] = self::HAS_MEETING_COLOR;
                $results[] = $item;
            }
        }
        return $results;
    }


    public function getDateOfRecurMonthly($startDate, $endDate, $currentDate)
    {

        $startDay = date('d', strtotime($startDate));
        $startMonth = date('m', strtotime($startDate));
        $startYear = date('Y', strtotime($startDate));
        $endDay = date('d', strtotime($endDate));
        $endMonth = date('m', strtotime($endDate));
        if ($startMonth == $endMonth) {
            // Ngày đầu tuần và cuối tuần cùng tháng
            // Ngày lặp thuộc tuần thì tạo ngày lặp cụ thể cho booking
            if ($startDay <= $currentDate && $endDay >= $currentDate) {
                $date = $startYear . '-' . $startMonth . '-' . $currentDate;
            }
        } else {
            // đầu tuần và cuối tuần khác tháng
            if ($startDay <= $currentDate) {
                $date = $startYear . '-' . $startMonth . '-' . $currentDate;
            } else if ($endDay >= $currentDate) {
                $date = $startYear . '-' . $endMonth . '-' . $currentDate;
            }
        }
        if (isset($date)) return $date;
        return null;
    }

    public function getDateOfRecurYearly($startDate, $endDate, $currentDate)
    {
        $firstDayOfWeek = date('Y-m-d', strtotime($startDate));
        $lastDayOfWeek = date('Y-m-d', strtotime($endDate));
        $startYear = date('Y', strtotime($startDate));
        $endYear = date('Y', strtotime($endDate));
        $currentMonth = date('m', strtotime($currentDate));
        // Nếu ngày đầu tuần và cuối tuần cùng một năm thì lấy năm đó để add booking
        if ($startYear == $endYear) {
            $date = date('Y-m-d', strtotime($startYear . '-' . $currentDate));
        } // Nếu ngày đầu tuấn và cuối tuần khác năm thì tháng bắt đầu sẽ là 12, tháng kết thúc là 1
        else {
            // Ngày lặp lại thuộc tháng 12 thì lấy năm của đầu tuần là năm của booking
            if ($currentMonth == 12)
                $date = date('Y-m-d', strtotime($startYear . '-' . $currentDate));

            // Ngày lặp lại thuộc tháng 1 thì năm của booking được add là năm của ngày cuối tuấn
            else if ($currentMonth == 1)
                $date = date('Y-m-d', strtotime($endYear . '-' . $currentDate));

        }
        // Kiểm tra ngày lặp lại có nằm trong tuần không
        if ($firstDayOfWeek <= $date && $date <= $lastDayOfWeek)
            return $date;
        else return null;
    }

    public function getUserTree()
    {
        $results = [];
        $jobtitles = [];
        foreach (JOB_TITLES_MEETING as $value => $name) {
            $jobtitles['J-' . $value] = $name;
        }
        $results['Chức danh'] = $jobtitles;
        $positions = [];
        foreach (POSITIONS_MEETING as $value => $name) {
            $positions['P-' . $value] = $name;
        }
        $results['Chức vụ'] = $positions;

        $teams = Team::select(DB::raw("CONCAT('T-', teams.id) as id"), DB::raw("CONCAT(groups.name, ' - ', teams.name) as name"))
            ->join('groups', 'groups.id', 'teams.group_id')
            ->orderBy('groups.name')
            ->pluck('name', 'id')->toArray();

        $results['Teams'] = $teams;

        $users = User::select('id', DB::raw('CONCAT(staff_code, " - ", name) as name'))->where('status', ACTIVE_STATUS)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name', 'id')->toArray();
        $results['Danh sách nhân viên'] = $users;

        return $results;
    }

    /**
     * @param Meeting $meeting
     * @param int     $type 0: create, 1: update, 2: delete, 3: meeting
     */
    public function sendMeetingNotice(Meeting $meeting, $type = 0)
    {
        if ($meeting->is_notify) {
            $userIds = $this->getParticipantIds($meeting);

            broadcast(new MeetingNoticeEvent($meeting, $userIds, $type))->toOthers();
        }
    }

    /**
     * @param $meeting
     *
     * @return array
     */
    public function getParticipantIds($meeting)
    {
        $users = User::select('id', 'name', 'jobtitle_id', 'position_id')->get();
        $userTeams = UserTeam::select('id', 'user_id', 'team_id')->get();
        $teams = Team::select('id', 'leader_id', 'name')->get();

        $userIds = [$meeting->users_id];
        $participantIds = is_array($meeting->participants) ? $meeting->participants : [$meeting->participants];

        foreach ($participantIds as $participantId) {
            if (starts_with($participantId, 'J-')) {
                $jobTitleId = str_replace('J-', '', $participantId);
                $selectUsers = $users->where('jobtitle_id', $jobTitleId)->pluck('id')->toArray();
                $userIds += $selectUsers;
            } elseif (starts_with($participantId, 'P-')) {
                $positionId = str_replace('P-', '', $participantId);
                $selectUsers = $users->where('position_id', $positionId)->pluck('id')->toArray();
                $userIds += $selectUsers;

            } elseif (starts_with($participantId, 'T-')) {
                $teamId = str_replace('T-', '', $participantId);
                $selectUsers = $userTeams->where('team_id', $teamId)->pluck('user_id')->toArray();
                $leaderId = $teams->firstWhere('id', $teamId)->leader_id ?? '';
                $userIds += $selectUsers;
                $userIds[] = $leaderId;

            } else {
                $userIds[] = (int)$participantId;
            }
        }

        return array_values(array_unique($userIds));
    }
}
