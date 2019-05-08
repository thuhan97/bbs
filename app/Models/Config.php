<?php
/**
 * ConfigModel class
 * Author: jvb
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

    public $timestamps = [
        'morning_start_work_at',
        'morning_end_work_at',
        'afternoon_start_work_at',
        'afternoon_end_work_at',
        'time_morning_go_late_at',
        'time_afternoon_go_late_at',
        'time_ot_early_at',
    ];

    protected $fillable = [
        'name',
        'acronym_name',
        'description',
        'work_days',
        'morning_start_work_at',
        'morning_end_work_at',
        'afternoon_start_work_at',
        'afternoon_end_work_at',
        'time_morning_go_late_at',
        'time_afternoon_go_late_at',
        'time_ot_early_at',
        'weekly_report_title',
        'html_weekly_report_template',
        'late_time_rule_json',
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
