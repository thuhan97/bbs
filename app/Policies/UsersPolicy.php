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
        if ($user->jobtitle_id == JOBTITLE_MANAGER) {
            return true;
        }
        return null;
    }
}
