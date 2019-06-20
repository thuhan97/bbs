<?php

namespace App\Transformers;

use App\Models\Event;
use League\Fractal;

/**
 * EventAttendanceListTransformer class
 * Author: jvb
 * Date: 2019/03/11 09:35
 */
class EventAttendanceListTransformer extends Fractal\TransformerAbstract
{
    public function transform(Event $event)
    {
        $registerList = $event->eventAttendanceList()->with('user:id,staff_code,name')->has('user')->get();
        $users = [];
        foreach ($registerList as $item) {
            $users[] = [
                'user_id' => $item->user_id,
                'staff_code' => $item->user->staff_code,
                'name' => $item->user->name,
                'content' => $item->user->content,
                'status' => $item->status,
                'created_at' => $item->created_at->format(DATE_FORMAT_DAY_OFF),
            ];
        }
        $data = $event->toArray();
        $data['users'] = $users;
        return $data;
    }
}
