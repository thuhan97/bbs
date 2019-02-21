<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

/**
 * UserTransformer class
 * Author: jvb
 * Date: 2018/07/16 10:34
 */
class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $item)
    {
        return $item->toArray();
    }
}
