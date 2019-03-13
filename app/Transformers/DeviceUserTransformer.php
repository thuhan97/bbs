<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\DeviceUser;

/**
* DeviceUserTransformer class
* Author: jvb
* Date: 2019/03/12 02:45
*/
class DeviceUserTransformer extends Fractal\TransformerAbstract
{
public function transform(DeviceUser $item)
{
return $item->toArray();
}
}
