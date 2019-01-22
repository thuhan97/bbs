<?php
/**
 * WorkTimeDetailModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class WorkTimeDetail extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'work_time_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'creator_id',
        'work_time_id',
        'touch_at',
        'place',
    ];
}
