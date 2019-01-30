<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkTime;

class UserController extends Controller
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
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

    public function dayOff()
    {
        return view('end_user.user.day_off');
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);

        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
