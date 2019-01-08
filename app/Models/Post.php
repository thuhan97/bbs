<?php
/**
 * PostModel class
 * Author: trinhnv
 * Date: 2018/11/11 13:59
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    public $autoCreator = true;

    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'posts';

    protected $fillable = [
        'creator_id',
        'name',
        'slug_name',
        'tags',
        'author_name',
        'image_url',
        'introduction',
        'content',
        'view_count',
        'like_count',
        'dislike_count',
        'share_count',
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

    public function getTagArrsAttribute()
    {
        if (!empty($this->attributes['tags'])) {
            return explode(',', $this->attributes['tags']);
        }
        return [];
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
            ->orWhere('slug_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('author_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('tags', 'like', '%' . $searchTerm . '%')
            ->orWhere('introduction', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%')
            ->orderBy('id', 'desc');
    }
}
