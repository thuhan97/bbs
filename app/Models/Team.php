<?php

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

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

    /**
     * @return mixed
     */
    public function getMemberNotInTeam($id = null)
    {
        $memberModel = new UserTeam;
        $member = $memberModel->getMemberIdAttribute();

        $users = User::whereNotIn('id', $member)
            ->orwhere('id', $id)
            ->get();
        return $users;
    }


}
