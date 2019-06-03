<?php 
/**
* SuggestionModel class
* Author: jvb
* Date: 2019/05/31 10:33
*/

namespace App\Models;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

protected $table = 'suggestions';

protected $primaryKey = 'id';

protected $fillable = [
    'id',
    'creator_id',
    'content',
    'created_at',
    'updated_at',
    'deleted_at',
    'status',
    'isseus_id',
    'comment',
    'isseus_comment'
];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'creator_id', 'id');
    }
    public function suggestions_isseus()
    {
        return $this->belongsTo('App\Models\User', 'isseus_id', 'id');
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
        $data= $query->where(function ($q) use ($searchTerm) {
            if ($searchTerm){
                $q=$q->orWhere('suggestions.content', 'like', '%' . $searchTerm . '%')
                    ->orWhere('suggestions.comment', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.name', 'like', '%' . $searchTerm . '%');
            }
        });
        $data=$data->join('users', 'users.id','=','suggestions.creator_id')
            ->select('suggestions.*')
            ->orderBy('suggestions.id', 'desc');

        return $data;

    }
}
