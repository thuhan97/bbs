<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
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

    public function edit(User $user, Project $project)
    {
        return $user->isManager() || $user->id === $project->leader_id || $this->checkEdit($project);
    }
    private function checkEdit($project){
        $ids=$project->projectMembers->pluck('user_id')->toArray();
        if ((Auth::user()->jobtitle_id == TEAMLEADER_ROLE || Auth::user()->jobtitle_id == MANAGER_ROLE) && in_array(Auth::id(),$ids)){
            return true;
        }else{
            return false;
        }

    }
}
