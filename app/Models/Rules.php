<?php
/**
 * RulesModel class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rules extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'rules';

    protected $fillable = [
        'id',
        'name',
        'detail',
        'penalize',
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
        return $query->where('name', 'like', '%' . $searchTerm . '%');
    }
}
