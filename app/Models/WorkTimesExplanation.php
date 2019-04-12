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

    protected $table = 'work_times_explanation';

    protected $fillable = [
        'id',
        'user_id',
        'work_day',
        'note',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }
}
