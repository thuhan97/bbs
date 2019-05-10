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

    const TYPES = [
        'normal' => 0,
        'lately' => 1,
        'early' => 2,
        'ot' => 3,
    ];

    public function scopeSearch($query, $searchWorkTimesExplanation)
    {
        return $query->where(function ($q) use ($searchWorkTimesExplanation) {
            $q->orWhere('work_day', 'like', '%' . $searchWorkTimesExplanation . '%')
                ->orWhere('users.name', 'like', '%' . $searchWorkTimesExplanation . '%')
                ->orWhere('users.staff_code', 'like', '%' . $searchWorkTimesExplanation . '%');
        })
            ->join('users', 'users.id', 'user_id')
            ->select('work_times_explanation.*')
            ->orderBy('work_times_explanation.id', 'desc');
    }

    protected $fillable = [
        'id',
        'user_id',
        'work_times_id',
        'work_day',
        'type',
        'note',
        'start_at',
        'end_at',
        'ot_type',
        'status',
        'approver_id',

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

    public function getTypeNameAttribute($key)
    {
        $type = $this->attributes['type'];
        switch ($type) {
            case 4:
                if ($this->attributes['ot_type'] === 1) {
                    return 'Xin OT dự án';
                } else {
                    return 'Xin OT cá nhân';
                }
                break;
            case 2:
                return 'Xin về sớm';
                break;
            case 1:
                return 'Xin đi muộn';
                break;
            default:
                break;
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }

    public function workTimeApprover()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
}
