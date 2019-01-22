<?php
/**
 * OverTimeModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class OverTime extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'ot_times';

    protected $fillable = [
        'id',
        'work_time_id',
        'creator_id',
        'minute',
        'reason',
        'status',
        'approver_id',
        'approver_at',
    ];
}
