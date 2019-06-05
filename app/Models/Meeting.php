<?php

namespace App\Models;

class Meeting extends Model
{
    protected $table = 'meetings';

    protected $fillable = [
        'title',
        'content',
        'users_id',
        'preside_id',
        'secretary_id',
        'participants',
        'meeting_room_id',
        'start_time',
        'end_time',
        'date',
        'is_notify',
        'color',
    ];

    public function getParticipantsAttribute($value)
    {
        return explode(',', $this->attributes['participants']);
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

}
