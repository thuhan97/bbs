<?php
/**
 * ShareModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use SoftDeletes;
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
        return $this->belongsTo('App\Models\User', 'creator_id', 'id');
    }

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
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->search($searchTerm);
            });
    }
}
