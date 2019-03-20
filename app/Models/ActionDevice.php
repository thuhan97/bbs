<?php
/**
 * ActionDeviceModel class
 * Author: jvb
 * Date: 2019/03/11 06:49
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionDevice extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'actions_devices';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'type',
        'types_device_id',
        'detail',
        'note',
        'deadline_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
