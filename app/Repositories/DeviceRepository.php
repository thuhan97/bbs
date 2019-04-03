<?php 
namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Contracts\IDeviceRepository;

/**
* DeviceRepository class
* Author: jvb
* Date: 2019/03/11 06:46
*/
class DeviceRepository extends AbstractRepository implements IDeviceRepository
{
/**
* DeviceModel
*
* @var  string
*/
protected $modelName = Device::class;
}
