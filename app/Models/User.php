<?php
/**
 * UserModel class
 * Author: trinhnv
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

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'staff_code',
        'name',
        'email',
        'phone',
        'password',
        'remember_token',
        'avatar',
        'id_card',
        'id_addr',
        'address',
        'current_address',
        'school',
        'birthday',
        'start_date',
        'end_date',
        'contract_type',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activate_code', 'activate_code_time', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $when = now()->addSeconds(30);
        $this->notify((new UserResetPassword($token, $this->email, $this->name))->delay($when));
    }

    /**
     * Encrypt password
     *
     * @param $value
     *
     * @author  TrinhNV
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = strlen($value) > 50 ? $value : bcrypt($value);
    }

    public function getAvatarAttribute()
    {
        if (empty($this->attributes['avatar']))
            return '\images\cartoon\no-avatar.png';
        return $this->attributes['avatar'];
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orwhere('staff_code', 'like', '%' . $searchTerm . '%')
            ->orwhere('phone', 'like', '%' . $searchTerm . '%')
            ->orWhere('email', 'like', '%' . $searchTerm . '%')
            ->orderBy('name');
    }

}
