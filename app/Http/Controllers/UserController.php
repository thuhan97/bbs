<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Http\Requests\Admin\WorkTimePermissionRequest;
use App\Http\Requests\Admin\WorkTimeRequest;
use App\Http\Requests\ApprovedRequest;
use App\Http\Requests\ApprovePermissionRequest;
use App\Http\Requests\AskPermissionRequest;
use App\Http\Requests\CreateDayOffRequest;
use App\Http\Requests\DayOffRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\WorkTimeCalendarRequest;
use App\Models\DayOff;
use App\Models\Group;
use App\Models\OverTime;
use App\Models\Project;
use App\Models\RemainDayoff;
use App\Models\User;
use App\Models\WorkTime;
use App\Models\WorkTimesExplanation;
use App\Repositories\Contracts\IDayOffRepository;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
use App\Transformers\DayOffTransformer;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;
    private $userDayOffService;
    private $dayOffRepository;

    public function __construct(IUserService $userService, IDayOffService $userDayOffService, IDayOffRepository $dayOffRepository)
    {
        $this->dayOffRepository = $dayOffRepository;
        $this->userService = $userService;
        $this->userDayOffService = $userDayOffService;
    }

    public function index()
    {
        return view('end_user.user.index');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('end_user.user.profile', compact('user'));
    }

    public function saveProfile(ProfileRequest $request)
    {
        $data = $request->only('address', 'current_address', 'gmail', 'gitlab', 'chatwork', 'skills', 'in_future', 'hobby', 'foreign_language', 'school');

        if ($request->hasFile('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = $avatar->getClientOriginalName();
            $destinationPath = public_path(URL_IMAGE_AVATAR);
            $data['avatar'] = URL_IMAGE_AVATAR . $avatarName;
            $avatar->move($destinationPath, $avatarName);
        }

        $user = User::updateOrCreate([
            'id' => Auth::id(),
        ], $data);

        return redirect(route('profile'))->with('success', 'Thiết lập hồ sơ thành công!');

    }

    public function changePassword()
    {
        return view('end_user.user.change_password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('auth.current_password_incorrect'));
                }
            },],
            'password' => 'required|confirmed|min:6|different:current_password',
        ], [
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ'
        ],
            ['password' => 'mật khẩu mới']
        );

        $user->password = $request->get('password');
        $user->save();
        Auth::logout();

        return redirect('/login')->with('notification_change_pass', __('messages.notification_change_pass'));
    }

    public function workTime()
    {
        return view('end_user.user.work_time');
    }

    /**
     * Show work time calendar
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workTimeAPI(Request $request)
    {
        $lastyear = (int)date('Y') - 1;
        $this->validate($request, [
            'year' => "required|min:" . $lastyear . "|integer|max:" . date('Y'),
            'month' => 'required|integer|max:12',
        ]);

        $calendarData = [];
        $list_work_times_calendar = WorkTime::where('user_id', Auth::id())
            ->whereYear('work_day', $request->year)
            ->whereMonth('work_day', $request->month);

        $explanation_calendar = WorkTimesExplanation::where('user_id', Auth::id())
            ->whereYear('work_day', $request->year)
            ->whereMonth('work_day', $request->month);
        if ($list_work_times_calendar) {
            foreach ($list_work_times_calendar->get()->toArray() as $item) {
                $startDay = $item['start_at'] ? new DateTime($item['start_at']) : '';
                $endDay = $item['end_at'] ? new DateTime($item['end_at']) : '';
                $dataStartDay = $item['start_at'];
                $dataEndDay = $item['end_at'];


                if ($dataStartDay && $dataStartDay != '00:00:00' || $dataEndDay && $dataEndDay != '00:00:00') {
                    if ($dataStartDay && $dataEndDay) {
                        $dataStartDay = $startDay->format('H:i');
                        $dataEndDay = $endDay->format('H:i');
                    } elseif ($dataEndDay == null || $dataEndDay == '00:00:00') {
                        $dataEndDay = '**:**';
                        $dataStartDay = $startDay->format('H:i');
                    } elseif ($dataStartDay == null || $dataStartDay == '00:00:00') {
                        $dataStartDay = '**:**';
                        $dataEndDay = $endDay->format('H:i');
                    }
                } elseif ($dataStartDay == '00:00:00' || $dataEndDay == '00:00:00' || $dataStartDay == null || $dataStartDay == '' || $dataEndDay == null || $dataEndDay == '') {
                    $dataStartDay = '**:**';
                    $dataEndDay = '**:**';
                } else {
                    $dataStartDay = '';
                    $dataEndDay = '';
                }
                $calendarData[] = [
                    'work_day' => $item['work_day'],
                    'start_at' => $dataStartDay,
                    'end_at' => $dataEndDay,
                    'type' => $item['type'],
                    'note' => $item['note'],
                    'id' => $item['id'],
                ];
            }
        }
        $calendarDataModal = [];
        if (isset($explanation_calendar)) {
            foreach ($explanation_calendar->get()->toArray() as $item) {
                $calendarDataModal[] = [
                    'id' => $item['id'],
                    'work_day' => $item['work_day'],
                    'type' => $item['type'],
                    'ot_type' => $item['ot_type'],
                    'status' => $item['status'],
                    'note' => $item['note'],
                    'user_id' => $item['user_id'],
                ];
            }
        }
        return response([
            'success' => true,
            'message' => 'success',
            'data' => $calendarData,
            'dataModal' => $calendarDataModal
        ]);
    }

    /**
     * Create or edit work time calendar
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dayOffCreateCalendar(WorkTimeRequest $request)
    {
        $reason = $request['reason'];
        $otType = $request['ot_type'];
        $explanationType = $request['explanation_type'];
        $workTimeExplanation = $this->getWorkTimeExplanation($request['work_day'])->where('type', $explanationType)->first();
        if ($workTimeExplanation) {
            $workTimeExplanation->update(['note' => $reason, 'ot_type' => $otType, 'type' => $explanationType]);
            return back()->with('day_off_success', '');
        } else {
            WorkTimesExplanation::create([
                'user_id' => Auth::id(),
                'work_day' => $request['work_day'],
                'type' => $explanationType,
                'ot_type' => $otType,
                'note' => $reason
            ]);
            return back()->with('day_off_success', 'day_off_success');
        }
    }

    public function workTimeDetailAskPermission(Request $request)
    {
        if ($request->has('explanationOtType')) {
            $workTimeExplanation = OverTime::where('creator_id', Auth::id())->where('work_day', $request['work_day'])->whereIn('status', array_values(WORK_TIME_OT_STATUS))->where('ot_type', $request['explanationOtType'])->first();
        } else if ($request->has('explanationType')) {
            $workTimeExplanation = $this->getWorkTimeExplanation($request['work_day'])->whereIn('status', array_values(WORK_TIME_OT_STATUS))->where('type', $request['explanationType'])->first();
        }
        $projectName = $this->projectActive()->toArray();
        $explanationRes = [];
        if ($workTimeExplanation) {
            $explanationRes = $workTimeExplanation->toArray();
            $explanationRes['project'] = $projectName;
            return $explanationRes;
        } else {
            return $projectName;
        }
        return 0;
    }

    public function workTimeAskPermission(WorkTimeCalendarRequest $request)
    {
        $minute = DateTimeHelper::getMinutesBetweenTwoTime($request['start_at'], $request['end_at']);
        $otType = $request['ot_type'];
        $reason = $request['reason'];
        $workDay = $request['work_day'];
        if ($request->has('ot_type')) {
            if ($request['ot_type'] == array_search('Dự án', OT_TYPE)) {
                $project = Project::find($request['project_id'])->name;
            } else {
                $project = null;
            }
            $workTimeExplanation = OverTime::where('creator_id', Auth::id())->where('work_day', $workDay)->where('status', '!=', array_search('Từ chối', OT_STATUS))->first();
            if ($workTimeExplanation) {
                $workTimeExplanation->update(['reason' => $reason, 'minute' => $minute, 'ot_type' => $otType, 'project_id' => $request['project_id'], 'project_name' => $project]);
                return back()->with('wt_permission_success', '');
            } else {
                OverTime::create([
                    'creator_id' => Auth::id(),
                    'minute' => $minute,
                    'work_day' => $request['work_day'],
                    'status' => array_search('Chưa duyệt', OT_STATUS),
                    'reason' => $reason,
                    'start_at' => $request['start_at'],
                    'end_at' => $request['end_at'],
                    'ot_type' => $otType,
                    'project_id' => $request['project_id'],
                    'project_name' => $project,
                ]);
                return back()->with('wt_permission_success', 'wt_permission_success');
            }
        } else if ($request['explanation_type'] == array_search('Đi muộn', WORK_TIME_TYPE) || $request['explanation_type'] == array_search('Về Sớm', WORK_TIME_TYPE)) {
            $workTimeExplanation = $this->getWorkTimeExplanation($workDay)->where('type', $request['explanation_type'])->first();
            if ($workTimeExplanation) {
                $workTimeExplanation->update(['type' => $request['explanation_type'], 'note' => $reason]);
                return back()->with('wt_permission_success', '');
            } else {
                WorkTimesExplanation::create([
                    'user_id' => Auth::id(),
                    'work_day' => $request['work_day'],
                    'type' => $request['explanation_type'],
                    'note' => $reason
                ]);
                return back()->with('wt_permission_success', 'wt_permission_success');
            }
        }
    }

    public function workTimeGetProject(Request $request)
    {
        return $this->projectActive()->toArray();
    }

    public function askPermission()
    {
        $query = WorkTimesExplanation::select(
            'work_times_explanation.id', 'work_times_explanation.work_day', 'work_times_explanation.type',
            'work_times_explanation.ot_type', 'work_times_explanation.note', 'work_times_explanation.status as work_times_explanation_status',
            'work_times_explanation.user_id', 'work_times_explanation.approver_id', 'work_times_explanation.reason_reject', 'ot_times.creator_id', 'ot_times.id as id_ot_time', 'ot_times.status as ot_time_status', 'users.name as approver')
            ->leftJoin('ot_times', function ($join) {
                $join->on('ot_times.creator_id', '=', 'work_times_explanation.user_id')
                    ->on('ot_times.work_day', '=', 'work_times_explanation.work_day');
            })->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'ot_times.approver_id');
            })
            ->whereYear('work_times_explanation.work_day', date('Y'));
        $queryLeader = clone $query;
        $dataLeader = $queryLeader->groupBy('work_times_explanation.work_day', 'work_times_explanation.type',
            'work_times_explanation.ot_type', 'work_times_explanation.note', 'work_times_explanation.user_id', 'ot_times.creator_id')
            ->where('user_id', '!=', Auth::id())
            ->orderBy('work_times_explanation.status', 'asc')
            ->orderBy('work_times_explanation.updated_at', 'desc')
            ->paginate(PAGINATE_DAY_OFF, ['*'], 'approver-page');
//
//        $datas = $query->where('user_id', Auth::id())
//            ->groupBy('work_times_explanation.work_day', 'work_times_explanation.type',
//                'work_times_explanation.ot_type', 'work_times_explanation.note', 'work_times_explanation.user_id', 'ot_times.creator_id')
//            ->orderBy('work_times_explanation.created_at', 'desc')
//            ->paginate(PAGINATE_DAY_OFF, ['*'], 'user-page');
//        $workTimeExplanation = WorkTimesExplanation::where('user_id', Auth::id())->where('work_day', date('Y-m-d'))->first();


        $askPermission = $this->permissionGetExplanation()->where('user_id', Auth::id())->get();
        $otTimes = $this->permissionGetOverTime()->where('creator_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $managerApproveOther = $this->permissionGetExplanation()->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->get();
        $managerApproveOT = $this->permissionGetOverTime()->orderBy('status', 'asc')->get();
        return view('end_user.user.ask_permission', compact('askPermission', 'otTimes', 'dataLeader', 'managerApproveOther', 'managerApproveOT'));
    }

    public function approveDetail(Request $request)
    {
        $datas = [];
        if ($request['permission-type'] == 'ot') {
            $overTime = OverTime::find($request['id']);
            $datas['id'] = $overTime['id'];
            $datas['creator_id'] = $overTime->creator->name;
            $datas['project_name'] = $overTime['project_name'];
            $datas['start_at'] = $overTime['start_at'];
            $datas['end_at'] = $overTime['end_at'];
            $datas['minute'] = $overTime['minute'];
            $datas['reason'] = $overTime['reason'];
        } elseif ($request['permission-type'] == 'other') {
            $workTimeExplanation = WorkTimesExplanation::find($request['id']);
            $datas['id'] = $workTimeExplanation['id'];
            $datas['user_id'] = $workTimeExplanation->creator->name;
            $datas['note'] = $workTimeExplanation['note'];
        }
        return $datas;
    }

    public function askPermissionCreate(AskPermissionRequest $request)
    {
        if (array_search('Overtime', WORK_TIME_TYPE) == $request['permission_type']) {
            $minute = DateTimeHelper::getMinutesBetweenTwoTime($request['start_at'], $request['end_at']);
            if ($request->has('project_name')) {
                $project = Project::find($request['project_id'])->name;
            } else {
                $project = null;
            }
            $overTime = OverTime::where('creator_id', Auth::id())->where('work_day', $request['work_day'])->first();
            if ($overTime == null && $request['permission_status'] == null) {
                OverTime::create([
                    'creator_id' => Auth::id(),
                    'work_day' => $request['work_day'],
                    'reason' => $request['note'],
                    'ot_type' => $request['ot_type'],
                    'minute' => $minute,
                    'start_at' => $request['start_at'],
                    'end_at' => $request['end_at'],
                    'project_id' => $request['project_id'],
                    'project_name' => $project,
                ]);
                return back()->with('create_permission_success', '');
            } else if ($request['permission_status'] == array_search('Bình thường', WORK_TIME_TYPE)) {
                OverTime::where('id', $request['ot_id'])->update(['reason' => $request['note'], 'ot_type' => $request['ot_type'], 'start_at' => $request['start_at'], 'end_at' => $request['end_at'], 'minute' => $minute, 'project_name' => $project, 'project_id' => $request['project_id']]);
                return back()->with('create_permission_success', 'create_permission_success');
            } else if ($request['permission_status'] == array_search('Đã duyệt', OT_STATUS)) {
                return back()->with('permission_error', '');
            }
        } elseif ($request['permission_type'] == array_search('Đi muộn', WORK_TIME_TYPE) || $request['permission_type'] == array_search('Về Sớm', WORK_TIME_TYPE)) {
            $workTimeExplanation = $this->getWorkTimeExplanation($request['work_day'])->where('status', array_search(' Chưa duyệt', OT_STATUS))->where('type', $request['permission_type'])->first();

            if ($workTimeExplanation) {
                $workTimeExplanation->update(['ot_type' => $request['ot_type'], 'note' => $request['note'], 'work_day' => $request['work_day']]);
            } else {
                WorkTimesExplanation::create([
                    'user_id' => Auth::id(),
                    'work_day' => $request['work_day'],
                    'type' => $request['permission_type'],
                    'ot_type' => $request['ot_type'],
                    'note' => $request['note'],
                ]);
            }
            return back()->with('create_permission_success', 'create_permission_success');
        }
    }

    public function askPermissionEarly(Request $request)
    {
        $workTimeExplanation = $this->getWorkTimeExplanation($request['work_day'])->first();
        if ($workTimeExplanation) {
            $workTimeExplanation->update(['ot_type' => $request['ot_type'], 'note' => $request['note'], 'work_day' => $request['work_day']]);
        } else {
            WorkTimesExplanation::create([
                'user_id' => Auth::id(),
                'work_day' => $request['work_day'],
                'type' => $request['type'],
                'ot_type' => $request['ot_type'],
                'note' => $request['note'],
            ]);
        }
        return back()->with('create_permission_success', '');
    }

    public function askPermissionModal(Request $request)
    {
        $validatedData = $request->validate([
            'data' => 'required|date',
            'type' => 'required|between:1,4',
        ]);
        if ($request['type'] == array_search('Overtime', WORK_TIME_TYPE)) {
            $datas = OverTime::where('work_day', $request['data'])->where('creator_id', Auth::id())/*->where('status', '!=', array_search('Đã duyệt', OT_STATUS))*/
            ->first();
        } else if ($request['type'] == array_search('Đi muộn', WORK_TIME_TYPE) || $request['type'] == array_search('Về Sớm', WORK_TIME_TYPE)) {
            $datas = WorkTimesExplanation::where('work_day', $request['data'])->where('type', $request['type'])->where('user_id', Auth::id())->first();
        }
        $projects = $this->projectActive();
        if ($datas) {
            return [$datas, $projects];
        } else {
            return ['', $projects];
        }
    }

    public function approvePermission(ApprovePermissionRequest $request)
    {
        if ($request['permission_type'] == 'ot') {
            OverTime::where('id', $request['id'])->update([
                'status' => $request['approve_type'],
                'note_respond' => $request['reason_approve'],
                'approver_id' => Auth::id(),
                'approver_at' => Carbon::now()
            ]);
            return back()->with('reject_success', '');
        } elseif ($request['permission_type'] == 'other') {
            WorkTimesExplanation::where('id', $request['id'])->update(
                [
                    'status' => $request['approve_type'],
                    'approver_id' => Auth::id(),
                    'reason_reject' => $request['reason_approve']
                ]);
        }
        return back()->with('approver_success', '');
    }

    public function approved(ApprovedRequest $request)
    {
        $workTimesExplanationID = $request['id'];
        if ($workTimesExplanationID) {
            WorkTimesExplanation::where('id', $workTimesExplanationID)->update(['status' => array_search('Đã duyệt', OT_STATUS), 'approver_id' => Auth::id()]);
            return back()->with('approver_success', '');
        }
    }

    public function approvedOT(ApprovedRequest $request)
    {
        $workTimesExplanationID = $request['id'];
        if ($workTimesExplanationID) {
            WorkTimesExplanation::where('id', $workTimesExplanationID)->update(['status' => array_search('Đã duyệt', OT_STATUS), 'approver_id' => Auth::id()]);
        }
        OverTime::create([
            'creator_id' => $request['user_id'],
            'reason' => $request['reason'],
            'status' => array_search('Đã duyệt', OT_STATUS),
            'approver_id' => Auth::id(),
            'approver_at' => now(),
            'work_day' => $request['work_day'],
        ]);
        return back()->with('approver_success', '');
    }

//
//
//  DAY OFF SECTION
//
//

    public function dayOff(DayOffRequest $request, $status = null)
    {
        $countDayOff = $this->userDayOffService->countDayOffUserLogin();
        $userManager = $this->userService->getUserManager();
        $availableDayLeft = $this->userDayOffService->getDayOffUser($request, Auth::id(), true);
        $autoShowModal = $request->has('t');
        if (isset($request->status_search) || isset($request->search_end_at) || isset($request->search_start_at)) {
            $searchStratDate = $request->search_start_at;
            $searchEndDate = $request->search_end_at;
            $statusSearch = $request->status_search;

            $dayOff = $this->userDayOffService->searchStatus($searchStratDate, $searchEndDate, $statusSearch);
            return view('end_user.user.day_off', compact('availableDayLeft', 'userManager', 'dayOff', 'statusSearch', 'countDayOff', 'searchEndDate', 'searchStratDate', 'autoShowModal'));
        }
        return view('end_user.user.day_off', compact('availableDayLeft', 'userManager', 'countDayOff', 'autoShowModal'));
    }

    public function dayOffListApprovalAPI(Request $request)
    {
        $response = [
            'success' => false,
            'message' => NOT_AUTHORIZED
        ];
        if (!$request->ajax() || !Auth::check()) {
            return response($response);
        }
        $user = Auth::user();
        $dataResponse = $this->userDayOffService->listApprovals((int)$user->jobtitle_id + 1);

        return response([
            'success' => true,
            'message' => "Danh Sách người phê duyệt",
            'data' => $dataResponse->toArray()
        ]);
    }

    public function dayOffApprove(DayOffRequest $request, $status = null)
    {
        $dataDayOff = $this->userDayOffService->showList($status);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff'
        ));
    }

    public function dayOffApprove_get(Request $request, $id)
    {
        if (!$request->ajax() || !Auth::check() || $id === null) {
            return null;
        }

        $responseObject = $this->userDayOffService->getRecordOf($id);
        if ($responseObject == null) return null;
        $transformer = new DayOffTransformer();

        return $transformer->transform($responseObject);
    }

    public function dayOffApprove_AcceptAPI(Request $request)
    {
        $response = [
            'success' => false,
            'message' => NOT_AUTHORIZED
        ];

//	     Checking authorize for action
        $isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;

        if (!$isApproval || !$request->ajax()) {
            return response($response);
        }

        $arrRequest = $request->all();
        $recievingObject = (object)$arrRequest;
//		return 	$recievingObject;

        $targetRecordResponse = $this->userDayOffService->updateStatusDayOff(
            $recievingObject->id, Auth::id(), $recievingObject->approve_comment,
            $recievingObject->number_off
        );

        if ($targetRecordResponse) {
            $response['message'] = 'Cập nhật thành công.';
            $response['success'] = true;
        } else {
            $response['message'] = 'Cập nhật thất bại. Đơn xin không tồn tại hoặc có lỗi xảy ra với server';
            $response['success'] = false;
        }
        return response($response);
    }

//
//
//  CONTACT
//
//

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);
        $groups = Group::all();
        return view('end_user.user.contact', compact('users', 'groups', 'search', 'perPage'));
    }

    /**
     * Create or edit day off
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dayOffCreatevacationVacation(CreateDayOffRequest $request)
    {
        if ($request->id_hid){
            $dayOff =DayOff::FindOrFail($request->id_hid);

        }else{
            $dayOff = new DayOff();
        }
        $dayOff->fill($request->all());
        $dayOff->user_id = Auth::id();
        $dayOff->save();
        if ($request->id_hid){
            return redirect(route('day_off'))->with('day_off_edit_success', '');
        }else{
            return redirect(route('day_off'))->with('day_off_success', '');
        }
    }

    public function dayOffCreate(CreateDayOffRequest $request)
    {

       if ($request->id_hid){
           $dayOff =DayOff::FindOrFail($request->id_hid);
       }else{
           $dayOff = new DayOff();
       }
        $dayOff->fill($request->all());
        $timeStrat = $request->start == DEFAULT_VALUE ? CHECK_TIME_DAY_OFF_START_DATE : CHECK_TIME_DAY_OFF_HALT_DATE;
        $timeEnd = $request->end == DEFAULT_VALUE ? CHECK_TIME_DAY_OFF_HALT_DATE : CHECK_TIME_DAY_OFF_END_DATE;
        $dayOff->start_at = $request->start_at . SPACE . $timeStrat;
        $dayOff->end_at = $request->end_at . SPACE . $timeEnd;
        $dayOff->title = DAY_OFF_TITLE_DEFAULT;
        $dayOff->user_id = Auth::id();
        $dayOff->save();

        if ($request->id_hid){
            return redirect(route('day_off'))->with('day_off_edit_success', '');
        }else{
            return redirect(route('day_off'))->with('day_off_success', '');
        }
    }

    public function dayOffSearch(Request $request)
    {
        $start = $request->search_start_at;
        $end = $request->search_end_at;
        $status = $request->status;
        $search = $request->search;
        $dataDayOff = $this->userDayOffService->showList(null);
        $dayOffSearch = $this->userDayOffService->getDataSearch($start, $end, $status, $search);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff', 'dayOffSearch', 'start', 'end', 'status', 'search'
        ));
    }

    public function dayOffShow($status)
    {
        $dataDayOff = $this->userDayOffService->showList($status);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff', 'status'
        ));
    }

    public function dayOffDetail($id, $check = false)
    {
        $dayOff = $this->userDayOffService->getOneData($id);
        if ($dayOff->status == STATUS_DAY_OFF['abide'] && $check) {
            $dayOff->status = STATUS_DAY_OFF['noActive'];
            $dayOff->save();
            return back()->with('close', '');
        }
        $numOff= $dayOff->number_off ? checkNumber($dayOff->number_off) : DEFAULT_VALUE;
        $absent= $dayOff->absent ? checkNumber($dayOff->absent) : DEFAULT_VALUE;

        if ($dayOff->title != REMAIN_DAY_OFF_DEFAULT){
            $timeStart= DateTimeHelper::checkTileDayOffGetDate($dayOff->start_at);
            $timeEnd= DateTimeHelper::checkTileDayOffGetDate($dayOff->end_at);
            $time=$timeStart.' - '.$timeEnd;

        }
        return response()->json([
            'data' => $dayOff,
            'numoff' => $numOff,
            'approver' => User::find($dayOff->approver_id)->name ?? '',
            'userdayoff' => User::find($dayOff->user_id)->name ?? '',
            'absent' => $absent + $numOff,
            'approver_id'=>User::find($dayOff->approver_id)->id ?? '',
            'timeStartEdit'=>Carbon::createFromFormat(DATE_TIME_FORMAT, $dayOff->start_at)->format('Y/m/d'),
            'timeEndEdit'=>Carbon::createFromFormat(DATE_TIME_FORMAT, $dayOff->end_at)->format('Y/m/d'),
            'time'=> $time ?? DEFAULT_VALUE
        ]);
    }

    public function editDayOffDetail(Request $request, $id)
    {
        $this->validate($request, [
            'number_off' => 'required|numeric|min:0',
            'approve_comment' => 'nullable|min:1|max:255'
        ]);
        $this->userDayOffService->calculateDayOff($request, $id);
        return back()->with('success', __('messages.edit_day_off_successully'));
    }

    public function deleteOrCloseDayOff(Request $request)
    {
        if (isset($request->day_off_id)) {
            DayOff::findOrFail($request->day_off_id)->delete();
            return back()->with('delete_day_off', '');
        } else if (isset($request->id_close)) {
            $dayOff = DayOff::findOrFail($request->id_close);
            if ($dayOff->status == STATUS_DAY_OFF['abide']) {
                $dayOff->status = STATUS_DAY_OFF['noActive'];
                $dayOff->save();
                return back()->with('close', '');
            }
        } else {
            abort(404);
        }
    }

    public function checkUsable(Request $request)
    {
        $dayOffPreYear = RemainDayoff::where('user_id', Auth::id())->where('year', date('Y') - PRE_YEAR)->first()->remain ?? DEFAULT_VALUE;
        $dayOffYear = RemainDayoff::where('user_id', Auth::id())->where('year', date('Y'))->first();
        $remainDayoffCurrentYear = $dayOffYear->remain ?? DEFAULT_VALUE;
        $DayoffFrreCurrentYear = $dayOffYear->day_off_free_female ?? DEFAULT_VALUE;
        $numOff = $this->userDayOffService->checkDateUsable($request->start_date, $request->end_date, $request->start_time, $request->end_time);
        if (is_array($numOff) && $numOff[0] > ($dayOffPreYear + $remainDayoffCurrentYear + $DayoffFrreCurrentYear)) {
            $absent = $numOff[0] - ($dayOffPreYear + $remainDayoffCurrentYear + $DayoffFrreCurrentYear);
            return response()->json([
                'check' => true,
                'absent' => $absent,
                'flag' => true
            ]);
        }
        if ($numOff > ($dayOffPreYear + $remainDayoffCurrentYear + $DayoffFrreCurrentYear)) {
            $absent = $numOff - ($dayOffPreYear + $remainDayoffCurrentYear + $DayoffFrreCurrentYear);
            return response()->json([
                'check' => true,
                'absent' => $absent
            ]);
        } else {
            return response()->json([
                'check' => false,

            ]);
        }
    }

    private function getWorkTimeExplanation($work_day)
    {
        return WorkTimesExplanation::where('user_id', Auth::id())->where('work_day', $work_day);
    }

    private function permissionGetExplanation()
    {
        return WorkTimesExplanation::where('type', '!=', 4);
    }

    private function permissionGetOverTime()
    {
        return OverTime::where('id', '!=', null);
    }

    private function projectActive()
    {
        return Project::where('status', Project::IS_ACTIVE)->get();
    }
}
