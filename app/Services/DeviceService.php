<?php 
/**
* DeviceService class
* Author: jvb
* Date: 2019/03/11 06:46
*/

namespace App\Services;

use App\Models\Device;
use App\Services\Contracts\IDeviceService;

class DeviceService extends AbstractService implements IDeviceService
{
    public function getDevicesByType($type) {
        return Device::where('types_device_id', $type)
                    ->where('final', '>', 0)
                    ->select('id', 'name', 'types_device_id')->get();
    }
}
