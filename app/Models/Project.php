<?php
/**
 * ProjectModel class
 * Author: jvb
 * Date: 2019/01/31 05:00
 */

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    public $autoCreator = true;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'customer',
        'project_type',
        'scale',
        'amount_of_time',
        'technical',
        'tools',
        'leader_id',
        'description',
        'start_date',
        'end_date',
        'image_url',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
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
        return $query->where('projects.name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('customer', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('scale', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('technical', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('tools', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
            ->orWhereHas('leader', function ($query) use ($searchTerm) {
                $query->search($searchTerm);
            });
    }

    public function leader()
    {
        return $this->hasOne('App\Models\User', 'id', 'leader_id');
    }

    /**
     * @return mixed
     */
    public function getLeadersProject()
    {
        return User::where('jobtitle_id', TEAMLEADER_ROLE)//Leader
        ->orWhere('jobtitle_id', MANAGER_ROLE)//Leader
        ->orderBy('jobtitle_id')
            ->get();
    }

}
