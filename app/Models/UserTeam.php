<?php

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class UserTeam extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    protected $table = 'user_teams';

    protected $fillable = [
        'name',
        'team_id',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'joining_team_date',
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

    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'team_id', 'id');
    }

    /**
     * @param $id
     *
     * @return mixed
     */


    /**
     * @return mixed
     */
    public function getMemberIdAttribute()
    {
        return $this->select(['user_id'])->groupBy(['user_id'])->get();
    }

    public static function getUsers($team_id = null)
    {
        return DB::table('user_teams')->where('team_id', $team_id)
            ->join('users', 'user_teams.user_id', '=', 'users.id')
            ->select('users.id', 'users.name')->distinct()
            ->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

    }
}
