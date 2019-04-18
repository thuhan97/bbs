<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class FloaIntFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'float_int_helper';
    }
}
