<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProvidedDevice;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the provided device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProvidedDevice  $providedDevice
     * @return mixed
     */
    public function view(User $user, ProvidedDevice $providedDevice)
    {
        return $user->isMaster() || $user->id == $providedDevice->manager_id || $user->id == $providedDevice->user_id;
    }
}
