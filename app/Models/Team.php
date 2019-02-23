<?php

namespace App\Models;


use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'leader_id',
        'color',
        'banner',
        'description',
        'slogan',
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
            $query->where('teams.name', 'LIKE', '%' . $searchTerm . '%');
            $query->orWhere('banner', 'LIKE', '%' . $searchTerm . '%');
            $query->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%');
        })
            ->select('teams.*')
            ->join('users', 'teams.leader_id', '=', 'users.id');
    }


    public function leader()
    {
        return $this->hasOne('App\Models\User', 'id', 'leader_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\UserTeam', 'team_id', 'id');
    }

    public function members()
    {
        return $this->hasManyThrough(User::class, UserTeam::class, 'team_id', 'id', 'id', 'user_id');
    }

    /**
     * @return mixed
     */
    public function getMemberNotInTeam($id = null)
    {
        $memberModel = new UserTeam;
        $member = $memberModel->getMemberIdAttribute();
        $users = User::whereNotIn('id', $member)
            ->whereIn('jobtitle_id', [TEAMLEADER_ROLE, MANAGER_ROLE, HEAD_DEPARTMENT_ROLE])//Leader
            ->orWhere('id', $id)
            ->get();
        return $users;
    }

    public function getMembers($id = null)
    {
        $memberModel = new UserTeam;
        $member = $memberModel->getMemberIdAttribute();

        $users = User::whereNotIn('id', $member)
            ->orwhere('id', $id)
            ->get();
        return $users;
    }

    public function save(array $options = [])
    {
        DB::beginTransaction();
        try {
            parent::save($options); // TODO: Change the autogenerated stub
            $newest_team = $this->orderBy('created_at', 'desc')->first();
            $newUserTeam = new UserTeam;
            $newUserTeam->team_id = $newest_team->id;
            $newUserTeam->user_id = $newest_team->leader_id;
            $newUserTeam->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }


}
