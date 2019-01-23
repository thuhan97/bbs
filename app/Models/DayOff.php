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

    /**
     * Search for course title or subject name
     *
     * @param $query
     * @param $searchTerm
     *
     * @return mixed
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhere('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('reason', 'like', '%' . $searchTerm . '%')
                ->orWhere('start_at', 'like', '%' . $searchTerm . '%')
                ->orWhere('end_at', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.staff_code', 'like', '%' . $searchTerm . '%');
        })
            ->join('users', 'users.id', 'user_id')
            ->select('day_offs.*')
            ->orderBy('day_offs.id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->where('status', ACTIVE_STATUS);
    }
}
