<?php
/**
 * EventModel class
 * Author: trinhnv
 * Date: 2018/10/07 16:46
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug_name',
        'image_url',
        'event_date',
        'introduction',
        'content',
        'view_count',
        'place',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at',
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
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('slug_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('introduction', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%')
            ->orderBy('id', 'desc');
    }
}
