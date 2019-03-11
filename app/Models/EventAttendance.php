<?php
/**
 * EventAttendanceListModel class
 * Author: jvb
 * Date: 2019/03/11 09:35
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAttendance extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'event_attendance';

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
}
