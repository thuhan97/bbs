<?php

namespace App\Http\Controllers;

use App\Events\ProvidedDeviceNoticeEvent;
use App\Http\Requests\ProvidedDeviceRequest;
use App\Models\ProvidedDevice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->jobtitle_id == MASTER_ROLE) {
            $providedDevic = ProvidedDevice::whereNull('deleted_at');
        } elseif ($user->jobtitle_id == MANAGER_ROLE) {
            $providedDevic = ProvidedDevice::where('manager_id', Auth::id());
        } else {
            $providedDevic = ProvidedDevice::where('user_id', Auth::id());
        }
        $providedDevic = $providedDevic->get();
        return view('end_user.device.index', compact('providedDevic'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ProvidedDeviceRequest $request)
    {
        $team = Auth::user()->team();
        $managerId = $team->group->manager_id ?? null;
        if ($managerId) {
            $providedDevic = new ProvidedDevice();
            if ($request->id_check) {
                $providedDevic = ProvidedDevice::FindOrFail($request->id_check);
            }
            $providedDevic->user_id = Auth::id();
            $providedDevic->manager_id = $managerId;
            $providedDevic->type_device = $request->type_device;
            $providedDevic->status = DEVICE_STATUS_ABIDE;
            $providedDevic->fill($request->all());
            $providedDevic->save();
            if ($request->id_check) {
                return back()->with('success', __l('device_edit_success'));
            }
            event(new ProvidedDeviceNoticeEvent($providedDevic, TYPE_DEVICE['send']));
            return back()->with('success', __l('device_create_success'));
        }
        abort(404);
    }

    public function delete(Request $request)
    {
        if ($request->id) {
            ProvidedDevice::find($request->id)->delete();
            return back()->with('delete_success', __l('device_delete_success'));
        }
        abort(404);
    }

    public function edit($id)
    {
        $userLogin = Auth::user();
        $providedDevic = ProvidedDevice::findOrFail($id);
        if ($providedDevic && $userLogin->can('view', $providedDevic)) {
            return response([
                'success' => 200,
                'data' => $providedDevic->toArray(),
                'name' => $providedDevic->user->name,
                'date_create' => Carbon::createFromFormat(DATE_TIME_FORMAT, $providedDevic->created_at)->format(DATE_TIME_FORMAT_VI),
                'return_date' => $providedDevic->return_date ? Carbon::createFromFormat(DATE_FORMAT, $providedDevic->return_date)->format(DATE_TIME_FORMAT_VI) : '',
            ]);
        }
        abort(404);

    }

    public function approval(Request $request)
    {
        $providedDevic = ProvidedDevice::findOrFail($request->id_check);
        if ($request->has('done')) {
            $providedDevic->status = STATUS_DEVICE['done'];
            $providedDevic->save();
            return back()->with('success', __l('device_done'));
        }
        $data = $request->all();
        $status = $request->get('status');
        if ($status == STATUS_DEVICE['approved'])
            $data['approved_at'] = Carbon::now();
        $providedDevic->fill($data);
        $providedDevic->save();
        event(new ProvidedDeviceNoticeEvent($providedDevic, TYPE_DEVICE['manager_approval']));
        return back()->with('success', __l('device_approvel_success'));
    }


}
