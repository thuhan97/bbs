<?php
/**
 * CalendarOffModel class
 * Author: jvb
 * Date: 2019/05/06 09:28
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarOff extends Model
{
    use SoftDeletes;

    protected $table = 'calendar_offs';

    protected $fillable = [
        'id',
        'date_name',
        'date_off_from',
        'date_off_to',
        'is_repeat',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
