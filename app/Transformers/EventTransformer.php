<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal;

/**
 * EventTransformer class
 * Author: trinhnv
 * Date: 2018/10/07 16:46
 */
class EventTransformer extends Fractal\TransformerAbstract
{
    public function transform(Event $item)
    {
        $data = $item->toArray();
        $data['date'] = $item->created_at->format(DATE_FORMAT);

        return $data;
    }
}
