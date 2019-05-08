<?php
/**
 * CalendarOffModel class
 * Author: jvb
 * Date: 2019/05/06 09:28
 */

namespace App\Models;

class CalendarOff extends Model
{
    const REPEAT = 1;

    protected $table = 'calendar_offs';

    protected $fillable = [
        'id',
        'date_name',
        'date_off_from',
        'date_off_to',
        'is_repeat',
    ];
}
