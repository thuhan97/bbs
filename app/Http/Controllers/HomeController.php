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


}
