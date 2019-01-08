<?php
/**
 * AdminModel class
 * Author: trinhnv
 * Date: 2018/09/03 01:52
 */

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
    ];

    public function getLogoPath()
    {
        return "/adminlte/img/avatar_" . rand(1, 5) . ".png";
    }
}
