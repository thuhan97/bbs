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
    const APPROVED_STATUS = 1;
    const NOTAPPROVED_STATUS = 0;

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
        'approve_comment',
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
        $data= $query->where(function ($q) use ($searchTerm) {
            if ($searchTerm){
                $q=$q->orWhere('day_offs.title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('day_offs.reason', 'like', '%' . $searchTerm . '%')
                    ->orWhere('day_offs.start_at', 'like', '%' . $searchTerm . '%')
                    ->orWhere('day_offs.end_at', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.staff_code', 'like', '%' . $searchTerm . '%');
            }
        });
        $data=$data->join('users', 'users.id','=','day_offs.user_id')
            ->select('day_offs.*')
            ->orderBy('day_offs.id', 'desc');

        return $data;

    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }

    public function approval()
    {
        return $this->hasOne(User::class, 'id', 'approver_id');
    }
}
