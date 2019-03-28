<?php

namespace App\Transformers;

use App\Models\DayOff;
use League\Fractal;

/**
 * DayOffTransformer class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class DayOffTransformer extends Fractal\TransformerAbstract
{
    public function transform(DayOff $item)
    {
        return $item->toArray();
    }
}
