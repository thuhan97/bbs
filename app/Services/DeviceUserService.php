<?php 
/**
* DeviceUserService class
* Author: jvb
* Date: 2019/03/12 02:45
*/

namespace App\Services;

use App\Models\DeviceUser;
use App\Services\Contracts\IDeviceUserService;

class DeviceUserService extends AbstractService implements IDeviceUserService
{

    public function findById($id) {
        return DeviceUser::where('devices_users.id', '=', $id)
                        ->join('devices', 'devices.id', '=', 'devices_users.devices_id')
                        ->select('devices.types_device_id as types_device_id', 'devices_users.*')
                        ->first();
    }

    public function getRecordByDeviceId($deviceId) {
        return DeviceUser::where('devices_id', $deviceId)
            ->join('users', 'users.id', '=', 'devices_users.users_id')
            ->join('devices', 'devices.id', '=', 'devices_users.devices_id')
            ->select('users.name as userName', 'devices.name as devicesName', 'devices_users.id', 'devices_users.code', 'devices_users.allocate_date', 'devices_users.return_date', 'devices_users.note')
            ->get();
    }
}
