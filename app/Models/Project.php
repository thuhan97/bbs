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

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'customer',
        'project_type',
        'scale',
        'amount_of_time',
        'technicala',
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
             $query->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('customer', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('scale', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('technicala', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('tools', 'LIKE', '%' . $searchTerm . '%');
             $query->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
         })
         ->select('projects.*')
             ->join('users', 'projects.leader_id', '=', 'users.id');
    }

    public function leader()
    {
        return $this->hasOne('App\Models\User', 'id','leader_id');
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getLeadersProject($id = null){
        $memberModel = new UserTeam;
        $member = $memberModel->getMemberIdAttribute();
        $users = User::whereNotIn('id', $member)
            ->where('jobtitle_id', TEAMLEADER_ROLE)//Leader
            ->orwhere('id', $id)
            ->get();
        return $users;
    }

}
