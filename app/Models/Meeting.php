<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'content',
        'users_id',
        'meeting_room_id',
        'paticipants',
        'start_time',
        'end_time',
        'date',
        'is_notify',
        'color',
    ];

}
