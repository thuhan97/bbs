<?php
/**
 * ShareModel class
 * Author: jvb
 * Date: 2019/05/07 10:50
 */

namespace App\Models;

class Suggestion extends Model
{
    protected $table = 'suggestions';

    protected $fillable = [
        'id',
        'creator_id',
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
