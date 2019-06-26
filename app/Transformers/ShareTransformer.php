<?php

namespace App\Transformers;

use App\Models\Share;
use League\Fractal;

/**
 * ShareDocumentTransformer class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
class ShareTransformer extends Fractal\TransformerAbstract
{
    public function transform(Share $item)
    {
        return $item->toArray();
    }
}
