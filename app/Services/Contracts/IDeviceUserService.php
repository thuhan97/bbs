<?php 
namespace App\Services\Contracts;

/**
* IDeviceUserService contract
* Author: jvb
* Date: 2019/03/12 02:45
*/
interface IDeviceUserService extends IBaseService {

    public function findById($id);

    public function getRecordByDeviceId($deviceId);
}
