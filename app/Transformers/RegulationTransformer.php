<?php

namespace App\Transformers;

use App\Models\Regulation;
use League\Fractal;

/**
 * RegulationTransformer class
 * Author: jvb
 * Date: 2019/01/11 09:23
 */
class RegulationTransformer extends Fractal\TransformerAbstract
{
    public function transform(Regulation $item)
    {
        return $item->toArray();
    }
}
