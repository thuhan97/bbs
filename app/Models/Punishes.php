<?php
/**
 * PunishesModel class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Punishes extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'punishes';

    const UNSUBMIT = 0;
    const SUBMITED = 1;

    protected $fillable = [
        'id',
        'rule_id',
        'user_id',
        'infringe_date',
        'total_money',
        'detail',
        'is_submit',
        'created_at',
        'updated_at',
        'deleted_at',
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
        if (isset($searchTerm)) {
            return $query->where(function ($q) use ($searchTerm) {
                $q->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.staff_code', 'like', '%' . $searchTerm . '%');
            })
                ->join('users', 'users.id', 'user_id')
                ->select('punishes.*')
                ->orderBy('punishes.id', 'desc');
        } else {
            return $query;
        }

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo(Rules::class);//->where('status', ACTIVE_STATUS);
    }
}
