<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;

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

    public function workTime()
    {
        return view('end_user.user.work_time');
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
