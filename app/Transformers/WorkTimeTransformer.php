<?php

namespace App\Transformers;

use App\Models\WorkTime;
use League\Fractal;

/**
 * WorkTimeTransformer class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class WorkTimeTransformer extends Fractal\TransformerAbstract
{
    public function transform(WorkTime $item)
    {
        return $item->toArray();
    }
}
