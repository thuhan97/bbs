<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\WorkTime;

class UserController extends Controller
{
    private $userService;
    private $userDayOff;

    public function __construct(IUserService $userService, IDayOffService $userDayOff)
    {
        $this->userService = $userService;
        $this->userDayOff = $userDayOff;
    }

    public function index()
    {
        return view('end_user.user.index');
    }

    public function profile()
    {
        return view('end_user.user.profile');
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

        return redirect('/login');
    }

    public function workTime(Request $request)
    {
        $late = $early = $ot = 0;
//        echo "<pre>"; print_r(Auth::user()->id);die;
        $month = $request->input('month');
        $type = $request->input('type');
        $t = array();
        if($type == 'di_muon'){
            $t = array(1, 3, 5);
        }elseif ($type == 've_som'){
            $t = array(2, 3);
        }elseif ($type == 'ot'){
            $t = array(4, 5);
        }
        $month = isset($month) ? $month : date('m');
//        $list_work_times = WorkTime::where('user_id', Auth::user()->id)->whereMonth('work_day', $month);
        if(!empty($t)){
            $list_work_times = WorkTime::where('user_id', Auth::user()->id)->whereIn('type', $t)->whereMonth('work_day', $month)->get();
//            print_r($type);die;
            if($type == 'di_muon'){
                $late = count($list_work_times);
            }elseif ($type == 've_som'){
                $early = count($list_work_times);
            }elseif ($type == 'ot'){
                $ot = count($list_work_times);
            }
        }else{
            $list_work_times = WorkTime::where('user_id', Auth::user()->id)->whereMonth('work_day', $month)->get();
            foreach ($list_work_times as $work_time){
                if($work_time['type'] == 1 || $work_time['type'] == 5 || $work_time['type'] == 3){
                    $late++;
                }
                if($work_time['type'] == 2 || $work_time['type'] == 3){
                    $early++;
                }
                if($work_time['type'] == 4 || $work_time['type'] == 5){
                    $ot++;
                }
            }
        }
//        echo "<pre>";print_r($list_work_times);die;

//        echo "<pre>"; print_r($list_work_times);die;
        return view('end_user.user.work_time', compact('list_work_times', 'late', 'early', 'ot'));
    }

    public function dayOff(DayOffRequest $request)
    {
        $conditions = ['user_id' => Auth::id()];
        $listDate = $this->userDayOff->findList($request, $conditions);

        $paginateData = $listDate->toArray();
        $recordPerPage = $request->get('per_page');
        $approve = $request->get('approve');

        $availableDayLeft = $this->userDayOff->getDayOffUser(Auth::id());
        return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve'));
    }

    public function dayOffApprove(DayOffRequest $request)
    {
        // Checking authorize for action
        $isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;

        // If user is able to do approve then
        $request->merge(['year' => date('Y')]);
        $search = $criterias['search'] ?? '';
        $totalRecord = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();

        return view('end_user.user.day_off_approval', compact('isApproval', 'totalRecord'));
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);
        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
