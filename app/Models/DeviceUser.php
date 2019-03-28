<?php
/**
 * DeviceUserModel class
 * Author: jvb
 * Date: 2019/03/12 02:45
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceUser extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'devices_users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'users_id',
        'devices_id',
        'code',
        'allocate_date',
        'return_date',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
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
        return $query->join('users', 'users.id', '=', 'devices_users.users_id')
                ->join('devices', 'devices.id', '=', 'devices_users.devices_id')
                ->select('users.name as userName', 'devices.name as devicesName', 'devices_users.id', 'devices_users.code', 'devices_users.allocate_date', 'devices_users.return_date', 'devices_users.note')
                ->where('users.name', 'like', '%' . $searchTerm . '%')
                ->orwhere('devices.name', 'like', '%' . $searchTerm . '%')
                ->orwhere('code', 'like', '%' . $searchTerm . '%');
    }
}
