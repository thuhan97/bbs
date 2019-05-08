<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable=[
    	'title',
    	'content',
    	'users_id',
    	'meetings_id',
    	'paticipants',
    	'start_time',
    	'end_time',
        'date',
    	'is_notify',
    	'color',
    ];

}
