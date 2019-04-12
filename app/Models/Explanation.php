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

class Explanation extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'explanation';

    protected $fillable = [
        'id',
        'user_id',
        'work_day',
        'note',
    ];

    const TYPE_NAMES = [
        0 => 'Bình thường',
        1 => 'Đi muộn',
        2 => 'Về sớm',
        3 => 'Overtime',
    ];

    const TYPES = [
        'normal' => 0,
        'lately' => 1,
        'early' => 2,
        'ot' => 4,
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhere('work_day', 'like', '%' . $searchTerm . '%')->orWhere('note', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.id', $searchTerm)
                ->orWhere('users.staff_code', 'like', '%' . $searchTerm . '%');
        })
            ->join('users', 'users.id', 'user_id')
            ->select('work_times.*')
            ->orderBy('work_times.work_day', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }
}
