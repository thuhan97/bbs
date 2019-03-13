<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Device;

/**
* DeviceTransformer class
* Author: jvb
* Date: 2019/03/11 06:46
*/
class DeviceTransformer extends Fractal\TransformerAbstract
{
public function transform(Device $item)
{
return $item->toArray();
}
}
