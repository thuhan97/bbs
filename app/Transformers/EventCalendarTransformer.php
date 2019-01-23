<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal;

/**
 * EventTransformer class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class EventCalendarTransformer extends Fractal\TransformerAbstract
{
    public function transform(Event $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->name,
            'description' => $item->introduction,
            'start' => $item->event_date,
            'end' => $item->event_end_date
        ];
    }
}
