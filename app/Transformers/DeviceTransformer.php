<?php

namespace App\Transformers;

use App\Models\Device;
use League\Fractal;

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
