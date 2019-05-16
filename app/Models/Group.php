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

    protected $table = 'group_id';

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
            $q->orWhere('group.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'like', '%' . $searchTerm . '%');
        })->join('users', 'users.id', '=','group.manager_id')
            ->select('group.*');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
}
