<?php 
namespace App\Services\Contracts;

/**
* IDeviceService contract
* Author: jvb
* Date: 2019/03/11 06:46
*/
interface IDeviceService extends IBaseService {

    public function getDevicesByType($type);
}
