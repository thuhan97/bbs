<?php
/**
 * Created by PhpStorm.
 * Handle some event for User model
 * Events: retrieved, creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restore
 * User: jvb
 * Date: 25/07/2018
 * Time: 15:29
 */

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle to the user "creating" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function creating(User $user)
    {
        if (empty($user->staff_code)) {
            $user->staff_code = $this->initStaffCode();
        }
    }

    /**
     * Handle to the user "created" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the topic "updating" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function updating(User $user)
    {
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function updated(User $user)
    {

    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    private function initStaffCode($length = 5)
    {
        return "J" . str_pad((\App\Models\User::max('id') + 1), 3, '0', STR_PAD_LEFT);
    }
}
