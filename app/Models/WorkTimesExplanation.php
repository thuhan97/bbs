<?php
/**
 * WorkTimeModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class WorkTimesExplanation extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'work_times_explanation';

    protected $fillable = [
        'id',
        'user_id',
        'work_times_id',
        'work_day',
        'type',
        'note',
        'ot_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }

    public function workTime()
    {
        return $this->belongsTo(WorkTime::class, 'work_times_id', 'id');
    }
}
