<?php
/**
 * ConfigModel class
 * Author: trinhnv
 * Date: 2018/11/15 16:31
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'config';

    protected $fillable = [
        'name',
        'address',
        'logo',
        'slogan',
        'term_register',
        'term_charge',
        'guide_search',
        'guide_test',
        'charge_email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'deleted_at',
    ];
}
