<?php

namespace App\Helpers;

use App\Models\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * DatabaseHelper
 * Author: jvb
 * Date: 2018/09/09
 */
class DatabaseHelper
{

    /**
     * Get Table instance
     *
     * @param Model $model
     *
     * @return Builder
     */
    public static function getTable($model)
    {
        return DB::table($model->getTable());
    }

    /**
     * Get Sql command
     *
     * @param Model $model
     *
     * @return mixed|string
     */
    public static function getQuery($model)
    {
        $query = str_replace(array('?'), array('\'%s\''), $model->toSql());
        return vsprintf($query, $model->getBindings());
    }

    /**
     * @param $query
     * @param $bindings
     *
     * @return mixed|string
     */
    public static function getQuerySql($query, $bindings)
    {
        $query = str_replace(array('?'), array('\'%s\''), $query);
        return vsprintf($query, $bindings);

    }


    /**
     * Get Sql command
     *
     * @param $sql
     * @param $bindings
     *
     * @return string
     */
    public static function parseQuery($sql, $bindings)
    {
        $query = str_replace(array('?'), array('\'%s\''), $sql);
        return vsprintf($query, $bindings);
    }

}
