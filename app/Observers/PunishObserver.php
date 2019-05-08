<?php

namespace App\Observers;

use App\Models\Punishes;

class PunishObserver
{
    /**
     * Handle the Punish "updating" event.
     *
     * @param Punishes $punish
     *
     * @return void
     */
    public function creating(Punishes $punish)
    {
        $punish->total_money = $punish->rule->penalize ?? 0;
    }

    /**
     * Handle the Punish "updating" event.
     *
     * @param Punishes $punish
     *
     * @return void
     */
    public function updating(Punishes $punish)
    {
        if ($punish->rule)
            $punish->total_money = $punish->rule->penalize;
    }
}
