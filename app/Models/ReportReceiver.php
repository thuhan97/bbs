<?php
/**
 * ReportReceiverModel class
 * Author: jvb
 * Date: 2019/05/23 10:36
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class ReportReceiver extends Model
{
    use  FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'report_receiver';

    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'user_id',
    ];
}
