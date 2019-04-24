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
use Illuminate\Notifications\Notifiable;

class OverTime extends Model
{
    use Notifiable, FillableFields, OrderableTrait, SearchLikeTrait;


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
        'work_day',
    ];

    public function scopeSearch($query, $searchOtTimes)
    {
        return $query->where('work_time_id', 'like', '%' . $searchOtTimes . '%')
            ->orWhere('creator_id', 'like', '%' . $searchOtTimes . '%')
            ->orWhere('status', 'like', '%' . $searchOtTimes . '%')
            ->orWhere('approver_at', 'like', '%' . $searchOtTimes . '%')
            ->orWhere('work_day', 'like', '%' . $searchOtTimes . '%')
            ->orWhere('approver_id', 'like', '%' . $searchOtTimes . '%');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id','id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id','id');
    }
}
