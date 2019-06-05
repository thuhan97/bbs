<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recur extends Model
{
    protected $fillable = [
        'title',
        'content',
        'users_id',
        'meeting_room_id',
        'paticipants',
        'start_time',
        'end_time',
        'repeat_type',
        'days_repeat',
        'is_notify'
    ];
}
