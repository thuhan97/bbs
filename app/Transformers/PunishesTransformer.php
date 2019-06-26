<?php

namespace App\Transformers;

use App\Models\Punishes;
use League\Fractal;

/**
 * PunishesTransformer class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
class PunishesTransformer extends Fractal\TransformerAbstract
{
    public function transform(Punishes $item)
    {
        return $item->toArray();
    }
}
