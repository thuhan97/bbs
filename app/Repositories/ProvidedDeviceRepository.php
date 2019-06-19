<?php 
namespace App\Repositories;

use App\Models\ProvidedDevice;
use App\Repositories\Contracts\IProvidedDeviceRepository;

/**
* ProvidedDeviceRepository class
* Author: jvb
* Date: 2019/06/17 14:30
*/
class ProvidedDeviceRepository extends AbstractRepository implements IProvidedDeviceRepository
{
/**
* ProvidedDeviceModel
*
* @var  string
*/
protected $modelName = ProvidedDevice::class;
}
