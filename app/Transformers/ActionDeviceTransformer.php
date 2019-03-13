<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\ActionDevice;

/**
* ActionDeviceTransformer class
* Author: jvb
* Date: 2019/03/11 06:49
*/
class ActionDeviceTransformer extends Fractal\TransformerAbstract
{
public function transform(ActionDevice $item)
{
return $item->toArray();
}
}
