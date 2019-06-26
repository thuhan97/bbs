<?php

namespace App\Transformers;

use App\Models\Share;
use League\Fractal;

/**
 * ShareExperienceTransformer class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
class ShareExperienceTransformer extends Fractal\TransformerAbstract
{
    public function transform(Share $item)
    {
        return $item->toArray();
    }
}
