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
use Illuminate\Notifications\Notifiable;
class Project extends Model
{
	public $autoCreator = true;
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'projects';
    

	protected $primaryKey = 'id';

    protected $fillable = [
        
            ];
    protected $hidden = [
       'create_at','updated_at', 'deleted_at',
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
         return $query->where(function ($query) use ($searchTerm) {
             $query->orWhere('projects.name', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('customer', 'LIKE', '%' . $searchTerm . '%');
         });
    }
    public function leader(){
        return $this->hasOne('App\User', 'id','leader_id');
    }
    
}
