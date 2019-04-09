<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDayOffRequest;
use App\Http\Requests\DayOffRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\WorkTime;
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

    public function __construct(IUserService $userService, IDayOffService $userDayOffService , IDayOffRepository $dayOffRepository)
    {
        $this->dayOffRepository=$dayOffRepository;
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

    public function workTime(Request $request)
    {
        $late = $early = $ot = 0;
        $month = $request->input('month') ?? date('m');
        $type = $request->input('type');
        $type_late = array(1, 3, 5);
        $type_early = array(2, 3);
        $type_ot = array(4, 5);
        $t = array();

        if ($type == 'di_muon') {
            $t = $type_late;
        } elseif ($type == 've_som') {
            $t = $type_early;
        } elseif ($type == 'ot') {
            $t = $type_ot;
        }

        $list_work_times = WorkTime::where('user_id', Auth::user()->id)->whereMonth('work_day', (int)$month - 1)->get();
        if (!empty($t)) {
            $list_work_times = $list_work_times->whereIn('type', $t);
            if ($type == 'di_muon') {
                $late = $list_work_times->count();
            } elseif ($type == 've_som') {
                $early = $list_work_times->count();
            } elseif ($type == 'ot') {
                $ot = $list_work_times->count();
            }
        } else {
            $late = $list_work_times->whereIn('type', $type_late)->count();
            $early = $list_work_times->whereIn('type', $type_early)->count();
            $ot = $list_work_times->whereIn('type', $type_ot)->count();
        }
        $calendarData = [];
        $list_work_times_calendar = WorkTime::where('user_id', Auth::user()->id)->get();
        foreach ($list_work_times_calendar->toArray() as $item) {
            $startDay = $item['start_at'] ? new DateTime($item['start_at']) : '';
            $dataStartDay = $startDay ? $startDay->format('H:i') : '';
            $endDay = $item['end_at'] ? new DateTime($item['end_at']) : '';
            $dataEndDay = $endDay ? $endDay->format('H:i') : '';
            $calendarData[] = [
                'work_day' => $item['work_day'],
//                'start_at' => $item['start_at'] ? $item['start_at']." - " : '',
                'start_at' => $dataStartDay,
                'end_at' => $dataEndDay,
                'type' => $item['type'],
                'note' => $item['note'],
                'attendance-time'=> $dataStartDay && $dataEndDay ?  " - "  : '' ,
            ];
        }
        return view('end_user.user.work_time', compact('list_work_times', 'late', 'early', 'ot','list_work_times_calendar','calendarData'));
    }

    //
    //
    //  DAY OFF SECTION
    //
    //

    public function dayOff(DayOffRequest $request)
    {
        $conditions = ['user_id' => Auth::id()];
        $listDate = $this->userDayOffService->findList($request, $conditions);

        $paginateData = $listDate->toArray();
        $recordPerPage = $request->get('per_page');
        $approve = $request->get('approve');
        $userManager = $this->userService->getUserManager();

        $availableDayLeft = $this->userDayOffService->getDayOffUser(Auth::id());
        return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve', 'userManager'));
    }

    /* public function dayOffCreate_API(DayOffRequest $request)
     {
         $response = [
             'success' => false,
             'message' => NOT_AUTHORIZED
         ];
         if (!$request->ajax() || !Auth::check()) {
             return response($response);
         }

         $indicate = $this->userDayOffService->create(
             Auth::id(), $request->input('title'),
             $request->input('reason'),
             $request->input('start_at'),
             $request->input('end_at'),
             $request->input('approver_id')
         );


         $response['message'] = !!$indicate['record'] ? "Gửi thành công!" : $indicate['message'];
         $response['success'] = $indicate['status'];
         $response['record'] = $indicate['record'];

         return response($response);
     }*/

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

    public function dayOffApprove(DayOffRequest $request,$status=null)
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

    public function dayOffCreate(CreateDayOffRequest $request)
    {
        $indicate = $this->userDayOffService->create(
            Auth::id(), $request->input('title'),
            $request->input('reason'),
            $request->input('start_at'),
            $request->input('end_at'),
            $request->input('approver_id')
        );
        return back()->with('day_off_success', '');

    }

    public function dayOffSearch(Request $request)
    {
        if ($request->search != ''){
            return $this->userDayOffService->getDataSearch($request->year, $request->month, $request->status,$request->search);
        }
        return $this->userDayOffService->getDataSearch($request->year, $request->month, $request->status,'');
    }
    public function dayOffShow($status){

        $dataDayOff = $this->userDayOffService->showList($status);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff'
        ));
    }

    public function dayOffDetail($id){
        $data= $this->userDayOffService->getOneData($id);
        $dataDayOff = $this->userDayOffService->showList(null);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff','data'
        ));

    }
    public function dayOffApproveOne($id){
        $dayOff= $this->dayOffRepository->findOne($id);
        if ($dayOff->status == 3){
            $check=['yes'];
        }else{
            $newStatus= $dayOff->status == 1 ? 3 : 1;
            $dayOff->status=$newStatus;
            $dayOff->save();
            $check=[];
        }

        $dataDayOff = $this->userDayOffService->showList(null);
        return view('end_user.user.day_off_approval', compact(
            'dataDayOff','check','dayOff'
        ));

    }


}
