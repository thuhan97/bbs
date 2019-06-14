<?php
/**
 * UserModel class
 * Author: jvb
 * Date: 2018/07/16 10:34
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
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

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
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }

}
