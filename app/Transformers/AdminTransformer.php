<?php

namespace App\Transformers;

use App\Models\Admin;
use League\Fractal;

/**
 * AdminTransformer class
 * Author: jvb
 * Date: 2018/09/03 01:52
 */
class AdminTransformer extends Fractal\TransformerAbstract
{
    public function transform(Admin $item)
    {
        return $item->toArray();
    }
}
