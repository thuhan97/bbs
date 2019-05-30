<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        Notification::where('user_id', Auth::id())->whereNull('read_at')->update([
            'read_at' => Carbon::now()
        ]);
        return response()->json('ok');
    }

}
