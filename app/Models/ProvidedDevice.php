<?php 
/**
* ProvidedDeviceModel class
* Author: jvb
* Date: 2019/06/17 14:30
*/

namespace App\Models;

use App\Notifications\UserResetPassword;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ProvidedDevice extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'provided_device';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'return_date',
        'approval_manager',
        'manager_id',
        'approval_hcnv',
        'status',
        'type_device'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function scopeSearch($query, $searchTerm)
    {
        $data= $query->where(function ($q) use ($searchTerm) {
            if ($searchTerm){
                $q=$q->orWhere('provided_device.title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('provided_device.approval_manager', 'like', '%' . $searchTerm . '%')
                    ->orWhere('provided_device.approval_hcnv', 'like', '%' . $searchTerm . '%')
                    ->orWhere('provided_device.content', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.name', 'like', '%' . $searchTerm . '%');
            }
        });
        $data=$data->join('users', 'users.id','=','provided_device.user_id')
            ->select('provided_device.*')
            ->orderBy('provided_device.id', 'desc');

        return null;

    }
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }
    public function manager()
    {
        return $this->belongsTo(User::class,'manager_id','id');//->where('status', ACTIVE_STATUS);
    }

}
