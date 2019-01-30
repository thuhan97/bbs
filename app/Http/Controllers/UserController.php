<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
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
        // get all request
        $totalRequest = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();
		// get only approved request
        $request->merge(['approve'=> 1]);
        $approvedRequest = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();

        return view('end_user.user.day_off_approval', compact('isApproval', 'totalRequest', 'approvedRequest'));
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);
        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
