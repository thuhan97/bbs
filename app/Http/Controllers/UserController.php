<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\WorkTimeRequest;
use App\Http\Requests\CreateDayOffRequest;
use App\Http\Requests\DayOffRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\DayOff;
use App\Models\OverTime;
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
use Illuminate\Support\Facades\DB;

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
        $data = $request->only('address', 'current_address', 'gmail', 'gitlab', 'chatwork', 'skills', 'in_future', 'hobby', 'foreign_laguage', 'school');

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
                $dataStartDay = $item['start_at'];
                if ($dataStartDay && $dataStartDay != '00:00:00') {
                    $dataStartDay = $startDay->format('H:i');
                } elseif ($dataStartDay == '00:00:00') {
                    $dataStartDay = '* * : * *';
                } else {
                    $dataStartDay = '';
                }
                $endDay = $item['end_at'] ? new DateTime($item['end_at']) : '';
                $dataEndDay = $endDay ? $endDay->format('H:i') : '17:30';
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
                    'work_day' => $item['work_day'],
                    'type' => $item['type'],
                    'ot_type' => $item['ot_type'],
                    'note' => $item['note'],
                    'user_id' => $item['user_id'],
                    'id' => $item['id'],
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dayOffCreateCalendar(WorkTimeRequest $request)
    {
        $id = $request['id'];
        $reason = $request['reason'];
        $workDay = $request['work_day'];
        $otType = $request['ot_type'];
        if ($id) {
            WorkTimesExplanation::where('user_id', Auth::id())->where('work_day', $workDay)->update(['note' => $reason, 'ot_type' => $otType]);
            return back()->with('day_off_success', '');
        } else {
            WorkTimesExplanation::create([
                'user_id' => Auth::id(),
                'work_day' => $request['work_day'],
                'type' => array_search('Đi muộn', WORK_TIME_TYPE),
                'ot_type' => $otType,
                'note' => $reason
            ]);
            return back()->with('day_off_success', 'day_off_success');
        }
    }

    public function askPermission()
    {
        $dataLeader = WorkTimesExplanation::select(
            'work_times_explanation.work_day', 'work_times_explanation.type',
            'work_times_explanation.ot_type', 'work_times_explanation.note',
            'work_times_explanation.user_id','ot_times.creator_id','ot_times.id as id_ot_time')
            ->leftjoin('ot_times', 'ot_times.creator_id', '=', 'work_times_explanation.user_id')
            ->whereYear('work_times_explanation.work_day', date('Y'))
            ->groupBy('work_times_explanation.work_day', 'work_times_explanation.type',
                'work_times_explanation.ot_type', 'work_times_explanation.note', 'work_times_explanation.user_id','ot_times.creator_id')
            ->orderBy('work_times_explanation.work_day', 'desc')
            ->paginate(PAGINATE_DAY_OFF, ['*'], 'Leader-page');
        $datas = WorkTimesExplanation::where('user_id', Auth::id())->whereYear('work_day', date('Y'))->orderBy('work_day', 'desc')->paginate(PAGINATE_DAY_OFF, ['*'], 'user-page');
        return view('end_user.user.ask_permission', compact('datas', 'dataLeader'));
    }

    public function approved(Request $request)
    {
        OverTime::create([
            'creator_id' => $request['user_id'],
            'reason' => $request['reason'],
            'status' => array_search('Đã duyệt', OT_STATUS),
            'approver_id' => Auth::id(),
            'approver_at' => now(),
            'work_day' => $request['work_day'],
        ]);
        return back();
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
        $availableDayLeft = $this->userDayOffService->getDayOffUser(Auth::id());
        if (isset($request->status_search) || isset($request->year)|| isset($request->month)) {
            $year=$request->year;
            $month=$request->month;
            $statusSearch=$request->status_search;

            $dayOff = $this->userDayOffService->searchStatus($year,$month,$statusSearch);
            return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve', 'userManager', 'dayOff', 'statusSearch', 'countDayOff','year','month'));
        }
        return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve', 'userManager', 'countDayOff'));
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

        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

    /**
     * Create or edit day off
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dayOffCreate(createDayOffRequest $request)
    {

        $dayOff = new DayOff();
        $dayOff->fill($request->all());
        $dayOff->user_id = Auth::id();
        $dayOff->save();
        return back()->with('day_off_success', '');
    }

    public function dayOffSearch(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $status = $request->status;
        $search = $request->search;

        $dataDayOff = $this->userDayOffService->showList(null);
        $dayOffSearch = $this->userDayOffService->getDataSearch($year, $month, $status, $search);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff', 'dayOffSearch', 'year', 'month', 'status', 'search'
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
        if ($dayOff->number_off){
            $numOff=checkNumber($dayOff->number_off);
        }
        return response()->json([
            'data' => $dayOff,
            'numoff'=> $numOff ?? null,
            'approver'=>User::findOrFail($dayOff->approver_id)->name,
            'userdayoff'=>User::findOrFail($dayOff->user_id)->name
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
        }else if (isset($request->id_close)){
            $dayOff=DayOff::findOrFail($request->id_close);
            if ($dayOff->status == STATUS_DAY_OFF['abide']){
                $dayOff->status = STATUS_DAY_OFF['noActive'];
                $dayOff->save();
                return back()->with('close', '');
            }
        }else
        {
            abort(404);
        }

    }

    public function tung(){
        dd($this->userDayOffService->statisticalDayOffExcel(14));
    }

}
