<?php
/**
 * DeviceModel class
 * Author: jvb
 * Date: 2019/03/11 06:46
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'devices';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'types_device_id',
        'name',
        'quantity_inventory',
        'quantity_used',
        'quantity_unused',
        'month_of_use',
        'final',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Search for course title or subject name
     *
     * @param $query
     * @param $searchTerm
     *
     * @return mixed
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->select('id', 'name', 'types_device_id', 'quantity_inventory', 'quantity_used', 'quantity_unused', 'month_of_use', 'final', 'note', DB::raw('count(*) as total'))
                    ->where('name', 'like', '%' . $searchTerm . '%')
                    ->groupBy('types_device_id');
    }
}
