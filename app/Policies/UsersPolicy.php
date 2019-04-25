<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manager($user)
    {
        if ($user->jobtitle_id >= MANAGER_ROLE) {
            return true;
        }
        return null;
    }

    public function teamLeader($user)
    {
        if ($user->jobtitle_id == TEAMLEADER_ROLE) {
            return true;
        }
        return null;
    }

    public function HCNS($user)
    {
        if ($user->jobtitle_id == HCNS) {
            return true;
        }
        return null;
    }

    public function BRSE($user)
    {
        if ($user->jobtitle_id == BRSE) {
            return true;
        }
        return null;
    }

    public function staff($user)
    {
        if ($user->jobtitle_id == STAFF) {
            return true;
        }
        return null;
    }
}
