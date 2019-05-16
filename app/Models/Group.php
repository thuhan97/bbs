<?php
/**
 * GroupModel class
 * Author: jvb
 * Date: 2019/05/16 14:31
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'manager_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhere('groups.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'like', '%' . $searchTerm . '%');
        })->join('users', 'users.id', '=', 'groups.manager_id')
            ->select('groups.*');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
