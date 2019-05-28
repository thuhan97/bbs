<?php

namespace App\Observers;

use App\Models\Regulation;

class RegulationObserver
{
    /**
     * Handle the Regulation "creating" event.
     *
     * @param Regulation $regulation
     *
     * @return void
     */
    public function creating(Regulation $regulation)
    {
        $this->updateAnotherOrder($regulation, false);
    }

    /**
     * Handle the Regulation "updating" event.
     *
     * @param Regulation $regulation
     *
     * @return void
     */
    public function updating(Regulation $regulation)
    {
        $this->updateAnotherOrder($regulation, true);
    }

    private function updateAnotherOrder($regulation, $isUpdate)
    {
        $model = Regulation::where('order', $regulation->order);
        if ($isUpdate) {
            $model->where('id', '!=', $regulation->id);
        }
        if ($model->exists()) {
            Regulation::where('order', '>=', $regulation->order)
                ->increment('order', 1);
        }

    }
}
