<?php
/**
 * AdditionalDateModel class
 * Author: jvb
 * Date: 2019/05/07 18:32
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class AdditionalDate extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'additional_dates';

    protected $fillable = [
        'date_add',
        'date_name',
    ];
}
