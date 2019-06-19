<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\ProvidedDevice;

/**
* ProvidedDeviceTransformer class
* Author: jvb
* Date: 2019/06/17 14:30
*/
class ProvidedDeviceTransformer extends Fractal\TransformerAbstract
{
public function transform(ProvidedDevice $item)
{
return $item->toArray();
}
}
