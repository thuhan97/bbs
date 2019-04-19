<?php
/**
 * RemainDayoffModel class
 * Author: jvb
 * Date: 2019/01/31 08:34
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemainDayoff extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'remain_dayoffs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'year',
        'remain'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
