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

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const UN_ACTIVE = 0;
    const IS_ACTIVE = 1;
    const LEVEL_DEFAULT = 1;

    protected $table = 'users';

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
        'probation_at',
        'start_date',
        'end_date',
        'contract_type',
        'status',
        'jobtitle_id',
        'position_id',
        'gmail',
        'gitlab',
        'chatwork',
        'skills',
        'in_future',
        'hobby',
        'foreign_language',
        'sex',
        'is_remote',
        'last_activity_at',
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
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $when = now()->addSeconds(30);
        $this->notify((new UserResetPassword($token, $this->email, $this->name))->delay($when));
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    /**
     * Encrypt password
     *
     * @param $value
     *
     * @author  jvb
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = strlen($value) > 50 ? $value : bcrypt($value);
    }

    public function getAvatarAttribute()
    {
        if (empty($this->attributes['avatar']))
            return URL_IMAGE_NO_IMAGE;
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
     * Get avaiable users
     *
     * @return mixed
     */
    public function availableUsers()
    {
        return $this->where('status', ACTIVE_STATUS)
            ->orderBy('staff_code');
    }

    /**
     * Get users who can approve
     *
     * @param int $minJobTitle
     *
     * @return mixed
     */
    public function approverUsers($minJobTitle = MIN_APPROVE_JOB)
    {
        return $this->where('status', ACTIVE_STATUS)->where('jobtitle_id', '>=', $minJobTitle)
            ->orderBy('staff_code');
    }

    /**
     * Get users who is probation staff
     *
     * @return mixed
     */
    public function probationUsers()
    {
        return $this->where('status', ACTIVE_STATUS)->where('contract_type', CONTRACT_TYPES['probation']);
    }

    public function team()
    {
        if (isset($this->attributes) && !empty($this->attributes)) {
            if ($this->attributes['jobtitle_id'] == TEAMLEADER_ROLE) {
                $team = Team::where('leader_id', $this->attributes['id'])->first();
                if ($team) return $team;
            }
            $userTeam = UserTeam::where('user_id', $this->attributes['id'])->orderBy('id', 'desc')->first();

            if ($userTeam) {
                return Team::where('id', $userTeam->team_id)->first();
            }
        }
    }

    public function isMaster()
    {
        return $this->attributes['jobtitle_id'] == MASTER_ROLE;
    }

    public function isManager()
    {
        return $this->attributes['jobtitle_id'] >= MANAGER_ROLE;
    }

    public function isGroupManager()
    {
        return Group::where('manager_id', $this->attributes['id'])->exists();
    }

    public function isTeamLeader()
    {
        return $this->attributes['jobtitle_id'] == TEAMLEADER_ROLE;
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
            ->orWhere('email', 'like', '%' . $searchTerm . '%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function remain_dayoff()
    {
        return $this->hasOne(RemainDayoff::class, 'id', 'user_id');
    }

    public function workTimeRegisters()
    {
        return $this->hasMany(WorkTimeRegister::class)->where('day', '!=', 7);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unread_notifications()
    {
        return $this->hasMany(Notification::class)->whereNull('read_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function firebase_tokens()
    {
        return $this->hasMany(UserFirebaseToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function active_firebase_tokens()
    {
        return $this->hasMany(UserFirebaseToken::class)->where('is_disabled', NOTIFICATION_ENABLE);
    }
}
