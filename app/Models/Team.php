<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\UserTeam;

class Team extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    protected $table = 'teams';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'leader_id',
        'banner',
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
        return $query->where(function($query) use ($searchTerm){
                $query->where('teams.name', 'LIKE', '%'.$searchTerm.'%');
                $query->orWhere('banner', 'LIKE', '%'.$searchTerm.'%');
                $query->orWhere('users.name', 'LIKE', '%'.$searchTerm.'%');
            })
            ->select('teams.*')
            ->join('users', 'teams.leader_id', '=', 'users.id')
            ->orderBy('teams.name');
    }

    /**
     * @return mixed
     */
    public function getUsersAttribute(){
        return User::where('id',  $this->attributes['leader_id'])->first()->name;
    }

    /**
     * @param $id
     * @return array
     */
    public function getAllMember($id){
        $memberModel = new UserTeam;
        $members = $memberModel->getMemberTeamAttribute($id);
        $membersWithName = [];
        foreach ($members as $member){
            $member->name = $this->getMemberName($member->user_id);
            $membersWithName[] = $member;
        }
        return $membersWithName;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMemberName($id){
        return User::where('id',  $id)->first()->name;
    }

}
