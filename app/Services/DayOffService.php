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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DayOffService extends AbstractService implements IDayOffService
{
    /**
     * DayOffService constructor.
     *
     * @param \App\Models\DayOff $model
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
     * @param array $moreConditions
     * @param array $fields
     * @param string $search
     * @param int $perPage
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
    public function getDayOffUser($request,$userId)
    {
        $model = $this->model->where('user_id', $userId);
        $remainDay = RemainDayoff::firstOrCreate(['user_id' => $userId]);
        $thisYear = (int)date('Y');
        $datas=$model->whereYear('start_at', $thisYear)
            ->select('*', DB::raw('DATE_FORMAT(start_at, "%d/%m/%Y (%H:%i)") as start_date'),
                DB::raw('DATE_FORMAT(end_at, "%d/%m/%Y (%H:%i)") as end_date'),
                DB::raw('DATE_FORMAT(approver_at, "%d/%m/%Y (%H:%i)") as approver_date'))
            ->orderBy('id', 'DESC');
        if ($request->month){
            $datas=$datas->whereMonth('start_at',$request->month);
        }
        if ($request->year){
            $datas=$datas->whereYear('start_at',$request->year);
        }
           $datas=$datas->paginate(PAGINATE_DAY_OFF);
        return [
            'data' => $datas,
            'total' => $remainDay->previous_year + $remainDay->current_year,
            'total_previous' => $remainDay->previous_year,
            'total_current' => $remainDay->current_year,
            'remain_current' => $model->whereYear('start_at', $thisYear)->where('status', DayOff::APPROVED_STATUS)->sum('number_off'),
            'remain_previous' => $model->whereYear('start_at', $thisYear - 1)->where('status', DayOff::APPROVED_STATUS)->sum('number_off')
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

    public function showList($status)
    {
        $model = $this->getdata()->whereYear('day_offs.start_at', '=', date('Y'));
        $data = clone $model->orderBy('id', 'DESC')->paginate(PAGINATE_DAY_OFF);

        if ($status != null) {
            $dataDate = $model;
            if ($status < ALL_DAY_OFF) {
                $dataDate = $dataDate->where('day_offs.status', $status);
            }
        } else {
            $dataDate = $model->whereMonth('day_offs.start_at', '=', date('m'));
        }
        $dataDate = $dataDate->orderBy('id', 'DESC')->paginate(PAGINATE_DAY_OFF);
        return [
            'dataDate' => $dataDate,
            'data' => $data,
            'total' => $data->count(),
            'totalActive' => $data->where('status', STATUS_DAY_OFF['active'])->count(),
            'totalAbide' => $data->where('status', STATUS_DAY_OFF['abide'])->count(),
            'totalnoActive' => $data->where('status', STATUS_DAY_OFF['noActive'])->count(),

        ];
    }

    public function getDataSearch($year, $month, $status, $search = null)
    {

        $data = $this->getdata();
        if ($year) {
            $data = $data->whereYear('day_offs.start_at', '=', $year);
        } else {
            $data = $data->whereYear('day_offs.start_at', '=', date('Y'));
        }
        if ($month) {
            $data = $data->whereMonth('day_offs.start_at', '=', $month);
        }
        if ($search) {
            $data = $data->Where('users.name', 'like', '%' . $search . '%');

        }
        if ($status < ALL_DAY_OFF) {
            $data = $data->where('day_offs.status', $status);
        }
        $data = $data->paginate(PAGINATE_DAY_OFF);
        return [
            'data' => $data,
        ];
    }

    public function getOneData($id)
    {
        return $data = $this->getdata(false, $id)->first();
    }

    public function countDayOff($id, $check = false)
    {
        if ($check) {
            $data = [
                'countDayOffCurrenYear' => $this->sumDayOff($id, null, false),
                'countDayOffPreYear' => $this->sumDayOff($id, TOTAL_MONTH_IN_YEAR, true),
            ];

        } else {
            $data = $this->model::groupBy('user_id', 'check_free')
                ->select('user_id', 'check_free', DB::raw('sum(number_off) as total'))
                ->where('user_id', $id)
                ->where('title','=', DAY_OFF_TITLE_DEFAULT)
                ->where('status', STATUS_DAY_OFF['active'])
                ->whereMonth('day_offs.start_at', '=', date('m'))
                ->whereYear('day_offs.start_at', '=', date('Y'))->first();
        }
        return $data;
    }

    /**
     * @param integer $status
     *
     * @return collection
     */
    public function searchStatus($year, $month, $status)
    {
        $data = DayOff::select('*', DB::raw('DATE_FORMAT(start_at, "%d/%m/%Y (%H:%i)") as start_date'),
            DB::raw('DATE_FORMAT(end_at, "%d/%m/%Y (%H:%i)") as end_date'),
            DB::raw('DATE_FORMAT(approver_at, "%d/%m/%Y (%H:%i)") as approver_date'))
            ->where('user_id', Auth::id());
        if ($year) {
            $data = $data->whereYear('start_at', '=', $year);
        } else {
            $data = $data->whereYear('start_at', '=', date('Y'));
        }
        if ($month) {
            $data = $data->whereMonth('start_at', '=', $month);
        }
        if ($status < ALL_DAY_OFF) {
            $data = $data->where('status', $status);
        }
        $data = $data->orderBy('id', 'DESC')
            ->paginate(PAGINATE_DAY_OFF);
        return $data;
    }


    /**
     *
     * @return array
     */

    public function countDayOffUserLogin()
    {
        $user = Auth::user();
        $total = $this->sumDayOff(null, null, false);
        $sumDayOffPreYear = RemainDayoff::where('user_id', $user->id)->where('year', (int)date('Y') - PRE_YEAR)->first();
        $sumDayOffCurrentYear = RemainDayoff::where('user_id', $user->id)->where('year', (int)date('Y'))->first();
        return $countDayyOff = [
            'total' => $total,
            'previous_year' => $sumDayOffPreYear->remain ?? DAY_OFF_DEFAULT,
            'current_year' => $sumDayOffCurrentYear->remain ?? DAY_OFF_DEFAULT
        ];
    }

    public function searchUserLogin($request)
    {
        // TODO: Implement searchUserLogin() method.
    }


    public function statisticalDayOffExcel($ids)
    {
        $result = [];
        $users = User::whereIn('id', $ids)->whereNull('end_date')->get();
        $dayOffMonth = $this->statisticalDayOff($ids);
        foreach ($users as $keys => $user) {
            $vacationMode= $this->statisticalVacationModeDayOff($user->id);
            $dayOffPreYear = RemainDayoff::where('user_id', $user->id)->where('year', date('Y') - PRE_YEAR)->first();
            $dayOffYear = RemainDayoff::where('user_id', $user->id)->where('year', date('Y'))->first();
            $dayOffPreYearTotal = $dayOffPreYear->remain ?? DEFAULT_VALUE;
            $dayOffYearTotal = $dayOffYear->remain ?? DEFAULT_VALUE;
            $totalMonth = [];
            if (count($dayOffMonth)) {
                foreach ($dayOffMonth as $key => $value) {
                    if ($value->user_id == $user->id) {
                        for ($i = 1; $i < 13; $i++) {
                            $month{$i} = $value->month == $i ? ($user->sex == SEX['female'] && $value->total >= TOTAL_DAY_OFF_IN_MONTH ? $value->total + $value->total_absent - DAY_OFF_FREE_ACTIVE : $value->total + $value->total_absent) : ($month{$i} ?? '0');
                            array_push($totalMonth, $month{$i});
                        }
                    }
                }
            } else {
                for ($i = 1; $i < 13; $i++) {
                    $month{$i} = '0';
                    array_push($totalMonth, $month{$i});
                }
            }
            $newTotalMonth=array_slice($totalMonth,count($totalMonth)-TOTAL_MONTH,count($totalMonth));
            $result[] = [
                'stt' => $keys + 1,
                'name' => $user->name,
                'staff_code' => $user->staff_code,
                'sex' => $user->sex == DEFAULT_VALUE ? 'Nam' : 'Nữ',
                'part_time' => $user->contract_type == CONTRACT_TYPES['parttime'] ? 'V' : '',
                'probation_at' => $user->probation_at ? Carbon::parse($user->probation_at)->format('d-m-Y') : '',
                'strat_date' => Carbon::parse($user->start_date)->format('d-m-Y'),
                'remain_day_off_current_year' => $dayOffYearTotal->remain_increment ?? '0',
                'remain_day_off_pre_year' => !empty($dayOffPreYearTotal) && $dayOffPreYear->remain_pre_year > DEFAULT_VALUE ? $dayOffPreYear->remain_pre_year : '0',
                'day_off_month_Jan' => $newTotalMonth[0],
                'day_off_month_Feb' => $newTotalMonth[1],
                'day_off_month_Mar' => $newTotalMonth[2],
                'day_off_month_Apr' => $newTotalMonth[3],
                'day_off_month_May' => $newTotalMonth[4],
                'day_off_month_Jun' => $newTotalMonth[5],
                'day_off_month_Jul' => $newTotalMonth[6],
                'day_off_month_Aug' => $newTotalMonth[7],
                'day_off_month_Sep' => $newTotalMonth[8],
                'day_off_month_Oct' => $newTotalMonth[9],
                'day_off_month_Nov' => $newTotalMonth[10],
                'day_off_month_Dec' => $newTotalMonth[11],
                'day_off_total' => array_sum($newTotalMonth),
                'day_off_regulation' =>  $vacationMode->total ?? '0',
                'day_off_remain_total' => $dayOffPreYearTotal + $dayOffYearTotal == DEFAULT_VALUE ? '0' : $dayOffPreYearTotal + $dayOffYearTotal,
                'day_off_end_year_reset' => $dayOffPreYearTotal == DEFAULT_VALUE ? '0' : $dayOffPreYearTotal,
                'day_off_turn_next_year' => $dayOffYearTotal == DEFAULT_VALUE ? '0' : $dayOffYearTotal,
            ];
        }

        return $result;
    }

    public function calculateDayOff($request, $id)
    {

        //manager active day off
        $dayOff = DayOff::findOrFail($id);
        //check reamin day off Current Year and Pre Year -> update column ramian of table remain_day_offs
        $userDayOff = User::findOrFail($dayOff->user_id);
        $dayOff->approver_at = now();
        $dayOff->approve_comment = $request->approve_comment;
        $dayOff->status = STATUS_DAY_OFF['active'];
        // user create day off = staff -> check remain day off table
        if ($dayOff->title != DAY_OFF_TITLE_DEFAULT && $userDayOff->contract_type == CONTRACT_TYPES['staff']){
            $dayOff->number_off=$request->number_off;

        }else if ($dayOff->title == DAY_OFF_TITLE_DEFAULT && $userDayOff->contract_type == CONTRACT_TYPES['staff'] && $userDayOff->end_date == null) {
            $dayOff->number_off = $request->number_off;
            // create new if reamin day off curent year = null
            $remainDayOffCurrentYear = RemainDayoff::where('user_id', $dayOff->user_id)->where('year',date('Y'))->first();

            $remainDayOffPreYear = RemainDayoff::where('user_id', $dayOff->user_id)->where('year', (int)date('Y') - 1)->first();
            $dayOffCurrentYear = $remainDayOffCurrentYear->remain ?? 0;
            $dayOffFreeCurrentYear = $remainDayOffCurrentYear->day_off_free_female ?? 0;
            $dayOffPreYear = $remainDayOffPreYear ? $remainDayOffPreYear->remain : DAY_OFF_DEFAULT;

            if ($dayOffPreYear + $dayOffFreeCurrentYear >= $request->number_off) {
                if ($dayOffFreeCurrentYear >= $request->number_off){
                    $remainDayOffPreYear->remain = $dayOffPreYear - $request->number_off;
                }else{

                }
                $remainDayOffPreYear->remain = $dayOffPreYear - $request->number_off;
                $remainDayOffPreYear->save();

            } elseif ($dayOffCurrentYear + $dayOffPreYear >= $request->number_off) {
                if ($remainDayOffPreYear) {
                    $remainDayOffPreYear->remain = DAY_OFF_DEFAULT;
                    $remainDayOffPreYear->save();
                }
                $remainDayOffCurrentYear->remain = $dayOffCurrentYear + $dayOffPreYear - $request->number_off;
                $remainDayOffCurrentYear->save();

            } else {
                if ($remainDayOffPreYear) {
                    $remainDayOffPreYear->remain = DAY_OFF_DEFAULT;
                    $remainDayOffPreYear->save();
                }
                $remainDayOffCurrentYear->remain = DAY_OFF_DEFAULT;
                $dayOff->absent = $request->number_off - ($dayOffCurrentYear + $dayOffPreYear);
                $dayOff->number_off = $request->number_off - $dayOff->absent;
                $remainDayOffCurrentYear->save();
            };
        } else {
            // user create day off != staff -> insert column absent table day off = total number off
            $dayOff->absent = $request->number_off;
        }
        $dayOff->save();

        // check if female && sum day off in month >=2 && check_free =0 -> +1 column remain table day off
        if ($userDayOff->sex == SEX['female'] && $userDayOff->contract_type == CONTRACT_TYPES['staff']) {

            //total day off in month
            $countDayOff = $this->countDayOff($userDayOff->id);
            if ($countDayOff && (int)$countDayOff->total >= TOTAL_DAY_OFF_IN_MONTH && $countDayOff->check_free == DAY_OFF_FREE_DEFAULT) {
                DayOff::where('user_id', $userDayOff->id)
                    ->whereMonth('start_at', '=', date('m'))
                    ->whereYear('start_at', '=', date('Y'))
                    ->update(['check_free' => DAY_OFF_FREE_ACTIVE]);
                $remainDayOffPreYear->remain = $remainDayOffPreYear->remain + DAY_OFF_FREE_ACTIVE;
                $remainDayOffCurrentYear->save();
            }
        }
    }

    /**
     * @param integer $month
     * @param Boolean $check
     *
     * @return collection
     */
    private function sumDayOff($user_id = null, $month = null, $check = false)
    {
        $user = $user_id ? User::findOrFail($user_id) : Auth::user();
        $total = 0;
        $monthSearch = $month ?? date('m');
        $yearSearch = $check ? (int)date('Y') - PRE_YEAR : date('Y');
        $data = $this->model::select('user_id', 'check_free', DB::raw('YEAR(start_at) year, MONTH(start_at) month'), DB::raw('sum(number_off) as total'), DB::raw('sum(absent) as total_absent'))
            ->groupBy('user_id', 'check_free', 'year', 'month')
            ->where('user_id', $user->id)
            ->where('status', STATUS_DAY_OFF['active'])
            ->whereMonth('start_at', '<=', $monthSearch)
            ->whereYear('day_offs.start_at', '=', $yearSearch)
            ->get();
        foreach ($data as $key => $value) {
            $total = $total + $value->total + $value->total_absent;
            if ($user->sex == SEX['female'] && $value->check_free == DAY_OFF_FREE_DEFAULT && $user->contract_type == CONTRACT_TYPES['staff']) {
                $total = $total - DAY_OFF_FREE_ACTIVE;
            }
        }
        return $total;
    }

    /**
     * @param integer $id
     * @param Boolean $check
     *
     * @return collection
     */
    private function getdata($check = true, $id = null)
    {
        $data = DayOff::select('day_offs.*', DB::raw('DATE_FORMAT(day_offs.start_at, "%d/%m/%Y (%H:%i)") as start_date'),
            DB::raw('DATE_FORMAT(day_offs.end_at, "%d/%m/%Y (%H:%i)") as end_date'),
            DB::raw('DATE_FORMAT(day_offs.approver_at, "%d/%m/%Y (%H:%i)") as approver_date'), 'users.name')
            ->join('users', 'users.id', '=', 'day_offs.user_id');
        if ($check) {
            $data = $data->where('day_offs.approver_id', Auth::id())
                ->where('day_offs.user_id', '<>', Auth::id())
                ->orderBy('day_offs.id', DESC);
            return $data;
        } else {
            $data = $data->where('day_offs.id', $id);
            return $data;
        }
    }

    private function statisticalVacationModeDayOff($id)
    {

        return $this->model::select('day_offs.user_id',
            DB::raw('YEAR(start_at) year'),
            DB::raw('sum(number_off) as total'))
            ->join('users', 'users.id', '=', 'day_offs.user_id')
            ->groupBy('day_offs.user_id', 'year')
            ->where('day_offs.user_id', $id)
            ->where('day_offs.status', STATUS_DAY_OFF['active'])
            ->whereYear('day_offs.start_at', '=', date('Y'))
            ->whereNull('users.end_date')
            ->whereIn('day_offs.title', ARRAY_TITLE_DAYOFF_VACATION_MODE)
             ->first();

    }


    private function statisticalDayOff($ids)
    {

        $datas = $this->model::select('day_offs.user_id', 'day_offs.check_free',
            DB::raw('YEAR(start_at) year, MONTH(start_at) month'),
            DB::raw('sum(number_off) as total'),
            DB::raw('sum(absent) as total_absfirstOrCreateent'))
            ->join('users', 'users.id', '=', 'day_offs.user_id')
            ->groupBy('day_offs.user_id', 'day_offs.check_free', 'year', 'month')
            ->whereIn('day_offs.user_id', $ids)
            ->where('day_offs.status', STATUS_DAY_OFF['active'])
            ->whereMonth('day_offs.start_at', '<=', date('m'))
            ->whereYear('day_offs.start_at', '=', date('Y'))
            ->whereNull('users.end_date')
            ->get();
        return $datas;
    }


}
