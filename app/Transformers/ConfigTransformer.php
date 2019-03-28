<?php

namespace App\Transformers;

use App\Models\Config;
use League\Fractal;

/**
 * ConfigTransformer class
 * Author: jvb
 * Date: 2018/11/15 16:31
 */
class ConfigTransformer extends Fractal\TransformerAbstract
{
    public function transform(Config $item)
    {
        return $item->toArray();
    }
}
