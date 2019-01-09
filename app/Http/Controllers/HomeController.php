<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('end_user.home');
    }

    public function profile()
    {
        return view('end_user.profile.index');
    }

    public function changePassword()
    {
        return view('end_user.profile.change_password');
    }
}
