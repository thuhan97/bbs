<?php

namespace App\Transformers;

use App\Models\ActionDevice;
use League\Fractal;

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
