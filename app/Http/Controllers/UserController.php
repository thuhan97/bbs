<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function workTime()
    {
        return view('end_user.user.work_time');
    }

    public function dayOff(Request $request)
    {

	    $listDate = $this->userDayOff->findList($request);
//    	dd($listDate);
        return view('end_user.user.day_off', compact('listDate'));
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);

        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
