<?php
/**
 * RegulationModel class
 * Author: jvb
 * Date: 2019/01/11 09:23
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regulation extends Model
{
    public $autoCreator = true;

    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'regulations';

    protected $fillable = [
        'id',
        'creator_id',
        'name',
        'content',
        'status',
        'approve_date',
        'file_path',
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
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regulation_files()
    {
        return $this->hasMany(RegulationFile::class);
    }
}
