<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserFirebaseToken;
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

    public function saveToken(Request $request)
    {
        $this->validate($request, [
            'notify_token' => 'required'
        ]);
        $token = $request->get('notify_token');
        $data = ['user_id' => Auth::id(), 'token' => $token];
        $userToken = UserFirebaseToken::where($data)->first();
        if (!$userToken) {
            $data['ip'] = $request->ip();
            $data['userAgent'] = $request->userAgent();
            $userToken = new UserFirebaseToken($data);
            $userToken->last_activity_at = Carbon::now();
        } else {
            //online so disable push notification
            $userToken->push_at = null;
            $userToken->last_activity_at = Carbon::now();
        }
        $userToken->save();
        return response()->json(['success' => true, 'id' => $userToken->id]);
    }

    public function enableNotification(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        UserFirebaseToken::where('id', $request->get('id'))->update([
            'is_disabled' => NOTIFICATION_ENABLE
        ]);

        return response()->json(['success' => true]);
    }

}
