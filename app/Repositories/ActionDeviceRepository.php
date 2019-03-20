<?php 
namespace App\Repositories;

use App\Models\ActionDevice;
use App\Repositories\Contracts\IActionDeviceRepository;

/**
* ActionDeviceRepository class
* Author: jvb
* Date: 2019/03/11 06:49
*/
class ActionDeviceRepository extends AbstractRepository implements IActionDeviceRepository
{
/**
* ActionDeviceModel
*
* @var  string
*/
protected $modelName = ActionDevice::class;
}
