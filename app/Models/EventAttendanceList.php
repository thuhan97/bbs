<?php
/**
 * EventAttendanceListModel class
 * Author: jvb
 * Date: 2019/02/28 07:38
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAttendanceList extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'event_attendance_list';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'event_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'content',
        'status',
    ];

    const STATUS_JOIN = [
        '1' => 'join',
        '0' => 'no_join',
    ];

}
