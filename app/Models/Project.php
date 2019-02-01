<?php 
/**
* ProjectModel class
* Author: jvb
* Date: 2019/01/31 05:00
*/

namespace App\Models;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

	protected $table = 'projects';

	protected $primaryKey = 'id';

    protected $fillable = [
            ];
}
