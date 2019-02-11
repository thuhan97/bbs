<?php
/**
 * DayOffService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

use App\Models\DayOff;
use App\Models\RemainDayoff;
use App\Models\User;
use App\Repositories\Contracts\IDayOffRepository;
use App\Services\Contracts\IDayOffService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DayOffService extends AbstractService implements IDayOffService
{
    /**
     * DayOffService constructor.
     *
     * @param \App\Models\DayOff                            $model
     * @param \App\Repositories\Contracts\IDayOffRepository $repository
     */
    public function __construct(DayOff $model, IDayOffRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * Query a list of day off
     *
     * @param Request $request
     * @param array   $moreConditions
     * @param array   $fields
     * @param string  $search
     * @param int     $perPage
     *
     * @return mixed
     */
    public function findList(Request $request, $moreConditions = [], $fields = ['*'], &$search = '', &$perPage = DEFAULT_PAGE_SIZE)
    {
        $criterias = $request->only('page', 'per_page', 'search', 'year', 'month', 'approve');
        $perPage = $criterias['per_page'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        $isApprove = $criterias['approve'] ?? null;
        if ($isApprove == DayOff::APPROVED_STATUS || $isApprove == DayOff::NOTAPPROVED_STATUS) {
            $moreConditions['day_offs.status'] = $isApprove;
        }

        $model = $this->model
            ->select($fields)
            ->with('approval')
            ->where($moreConditions)
            ->search($search)
            ->orderBy('id');

        $year = $criterias['year'] ?? null;

        if ($year != null) {
            $model->whereYear('start_at', $year);
        }

        $month = $criterias['month'] ?? null;
        if ($month != null) {
            $model->whereMonth('start_at', $month);
        }

        return $model->paginate($perPage);
    }

    public function listApprovals($minJobTitle = 1)
    {
        $containerRecord = new User();

        $listApproval = $containerRecord->approverUsers($minJobTitle);
        return $listApproval->get();
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public function getDayOffUser($userId)
    {
        $model = $this->model->where('user_id', $userId)->where('status', DayOff::APPROVED_STATUS);
        $remainDay = RemainDayoff::firstOrCreate(['user_id' => $userId]);

        $thisYear = (int)date('Y');
        return [
            'total' => $remainDay->previous_year + $remainDay->current_year,
            'total_previous' => $remainDay->previous_year,
            'total_current' => $remainDay->current_year,
            'remain_current' => $remainDay->current_year - $model->whereYear('start_at', $thisYear)->sum('number_off'),
            'remain_previous' => $remainDay->previous_year - $model->whereYear('start_at', $thisYear - 1)->sum('number_off')
        ];
    }

    public function updateStatusDayOff($recordID, $approvalID, $comment, $approve = DayOff::APPROVED_STATUS, $number_off = 0.5)
    {
        $approval = User::find($approvalID);
        if ($approval == null || $approval->id == null || $approval->jobtitle_id < \App\Models\Report::MIN_APPROVE_JOBTITLE) {
            return false;
        }
        $record = $this->model
            ->where('id', $recordID)
            ->where('status', DayOff::NOTAPPROVED_STATUS)->first();
        if ($record !== null && $record->id !== null) {
            $record->approver_id = $approval->id;
            $record->approve_comment = $comment;
            $record->status = DayOff::APPROVED_STATUS;
            $record->approver_at = Carbon::now();
            $record->number_off = $number_off;
            return $record->update() != null;
        } else {
            return false;
        }
    }

    public function getRecordOf($idRecord)
    {
        $recordFound = $this->model->with('user')->find($idRecord);
        return $recordFound;
    }

    public function create($idUser, $title, $reason, $start_at, $end_at, $approvalID)
    {
        $existed = DayOff::where('status', DayOff::APPROVED_STATUS)
            ->where("start_at", "<=", $start_at)
            ->where("end_at", ">=", $end_at)->first();

        if ($existed !== null && $existed->id !== null) {
            return [
                "status" => false,
                "record" => null,
                "message" => "Đã tồn tại"
            ];
        }

        $rec = new DayOff([
            'user_id' => $idUser,
            'title' => $title,
            "reason" => $reason,
            "start_at" => $start_at,
            "end_at" => $end_at,
            "status" => 0,
            "approver_id" => $approvalID
        ]);

        $result = $rec->save();
        return [
            "status" => $result,
            "record" => $result ? $rec : null,
            "message" => "Tạo đơn thất bại"
        ];
    }
}
