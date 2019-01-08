<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal;

/**
 * PostTransformer class
 * Author: trinhnv
 * Date: 2018/11/11 13:59
 */
class PostTransformer extends Fractal\TransformerAbstract
{
    public function transform(Post $item)
    {
        $item->created_time = $item->created_at->format(DATE_TIME_FORMAT_SHORT);
        return $item->toArray();
    }
}
