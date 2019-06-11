<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'users_id',
        'meeting_id',
        'meeting_room_id',
        'title',
        'content',
        'participants',
        'start_time',
        'end_time',
        'repeat_type',
        'days_repeat',
        'is_notify'
    ];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }
}
