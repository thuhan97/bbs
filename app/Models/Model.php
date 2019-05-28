<?php
/**
 * Created by PhpStorm.
 * User: jvb
 * Date: 28/12/2017
 * Time: 15:29
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public $autoCreator = false;
    public $autoOrder = false;

    /**
     * @return string
     */
    public static function table()
    {
        return with(new static)->table;
    }

    /**
     * Insert each item as a row. Does not generate events.
     *
     * @param  array $items
     *
     * @return bool
     */
    public static function insertAll(array $items)
    {
        $now = Carbon::now();

        $items = collect($items)->map(function (array $data) use ($now) {
            if (with(new static)->autoCreator && !isset($data['creator_id'])) {
                $data['creator_id'] = Auth::id();
            }
            if (with(new static)->autoRank && !isset($data['order'])) {
                $data['order'] = with(new static)->max('order') + 1;
            }
            return with(new static)->timestamps ? array_merge([
                with(new static)::CREATED_AT => $now,
                with(new static)::UPDATED_AT => $now,
            ], $data) : $data;
        })->all();

        return DB::table(static::table())->insert($items);
    }
}
