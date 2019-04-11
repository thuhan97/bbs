<?php
/**
 * ShareModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

class Share extends Model
{
    protected $table = 'shares';

    protected $fillable = [
        'id',
        'creator_id',
        'name',
        'type',
        'content',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','creator_id','id');
    }
}
