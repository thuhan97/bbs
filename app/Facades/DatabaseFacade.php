<?php

namespace App\Facades;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * DatabaseFacade
 *
 * @method static Builder getTable($model)
 * @method static mixed|string getQuery($model)
 * @method static mixed|string getQuerySql($model)
 *
 * @see \App\Helpers\DatabaseHelper
 */
class DatabaseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database_helper';
    }
}
