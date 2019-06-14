<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvidedDeviceRequest;
use App\Models\ProvidedDevice;
use App\Models\Team;
use App\Models\UserTeam;
use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->jobtitle_id == MASTER_ROLE) {
            $providedDevic=ProvidedDevice::all();
        }
        if ($user->jobtitle_id == MANAGER_ROLE) {
            $providedDevic=ProvidedDevice::where('manager_id',Auth::id())->get();
        }else {
            $providedDevic = ProvidedDevice::where('user_id',Auth::id())->get();
        }
        return view('end_user.device.index',compact('providedDevic'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ProvidedDeviceRequest $request){
        $user=Auth::user();
        if ($user->jobtitle_id == TEAMLEADER_ROLE) {
            $team = Team::where('leader_id', Auth::id())->first();
        } else if($user->jobtitle_id == 0) {
            $team = UserTeam::where('user_id', Auth::id())->first()->team ?? null;
        }
        $managerId = $team->group->manager_id ?? null;
        if ($managerId){
            $providedDevic=new ProvidedDevice();
            $providedDevic->user_id=Auth::id();
            $providedDevic->manager_id=$managerId;
            $providedDevic->status=2;
            $providedDevic->fill($request->all());
            $providedDevic->save();
            return back()->with('success',__l('device_create_success'));
        }else{
            return back()->with('not_success',__l('device_create_not_success'));
        }
    }

}
