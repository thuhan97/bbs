<?php

namespace App\Models;


use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Manager extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'manager_group';

    protected $fillable = [
        'name',
        'manager',
        'color',
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
        return null;
       /* return $query->where(function ($query) use ($searchTerm) {
            if (!empty($searchTerm)) {
                $query->where('teams.name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('banner', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%');

                //search teams

                $groupIds = array_filter(GROUPS, function ($key) use ($searchTerm) {
                    return starts_with(mb_strtolower(GROUPS[$key]), mb_strtolower($searchTerm));
                }, ARRAY_FILTER_USE_KEY);
                if (!empty($groupIds)) {
                    $query->orWhereIn('group_id', array_keys($groupIds));
                }
            }
        })
            ->select('teams.*')
            ->join('users', 'teams.leader_id', '=', 'users.id');*/
    }

}
