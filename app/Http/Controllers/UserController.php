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
		$conditions = ['user_id' => Auth::id()];
		$listDate = $this->userDayOff->findList($request, $conditions);

		$paginateData = $listDate->toArray();
		$recordPerPage = $request->only('per_page');
		$recordPerPage = $recordPerPage['per_page'] ?? null;
		$queryApprove = $request->only('approve');
		$queryApprove = $queryApprove['approve'] ?? null;
		$approve = $queryApprove !== null ? ($queryApprove != 1 && $queryApprove != 0 ? null : $queryApprove) : null;

		$availableDayLeft = $this->userDayOff->getDayOffUser(Auth::id());

		return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve'));
	}

	public function contact(Request $request)
	{
		$users = $this->userService->getContact($request, $perPage, $search);
		return view('end_user.user.contact', compact('users', 'search', 'perPage'));
	}

}
