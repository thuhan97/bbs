<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimpleXMLElement getXML($path)
 *
 * @see \App\Helpers\UrlHelper
 */
class UrlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'url_helper';
    }
}
