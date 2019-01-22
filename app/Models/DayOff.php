<?php
/**
 * DayOffModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayOff extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'day_offs';

    protected $fillable = [
        'id',
        'user_id',
        'leave_id',
        'title',
        'reason',
        'start_at',
        'end_at',
        'number_off',
        'status',
        'approver_id',
        'approver_at',
    ];
}
