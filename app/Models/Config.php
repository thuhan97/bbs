<?php
/**
 * ConfigModel class
 * Author: trinhnv
 * Date: 2019/01/22 02:41
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'configs';

    protected $fillable = [
        'name',
        'acronym_name',
        'work_days',
        'start_work_at',
        'end_work_at',
        'weekly_report_title',
        'html_weekly_report_template',
    ];

    public function setWorkDaysAttribute($value)
    {
        $this->attributes['work_days'] = implode(',', $value);
    }

    public function getWorkDaysAttribute()
    {
        if (empty($this->attributes['work_days']))
            return [];
        return explode(',', $this->attributes['work_days']);
    }
}
