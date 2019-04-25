<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * AdminController
 * Author: jvb
 * Date: 2018/09/03 01:52
 */
class MasterController extends Controller
{
    /**
     * Controller construct
     */
    public function __construct()
    {
    }

    public function index()
    {
        $probationStaffs = (new User())->probationUsers()->paginate(8);
        $events = Event::where('status', ACTIVE_STATUS)->orderBy('id', 'desc')->get();

        return view('admin.master', compact('probationStaffs', 'events'));
    }

    public function download(Request $request)
    {
        if (Storage::exists($request->file_path))
            return Storage::download($request->file_path);
    }
}
