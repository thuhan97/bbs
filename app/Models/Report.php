<?php
/**
 * ReportModel class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'reports';

    const MIN_APPROVE_JOBTITLE = 1;

    protected $fillable = [
        'id',
        'year',
        'month',
        'week_num',
        'user_id',
        'to_ids',
        'title',
        'content',
        'status',
        'report_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->where('status', ACTIVE_STATUS);
    }

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
        return $query->where('title', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%');
    }

    public function getTitle($type, $year, $month)
    {
        if ($type == REPORT_SEARCH_TYPE['private']) {
            $reportType = $this->attributes['report_type'];

            $title = "Báo cáo " . (REPORT_TYPES[$reportType] ?? '') . " ";
            if ($reportType == REPORT_TYPE_DAILY) {
                $title .= date_format(new \DateTime($this->attributes['created_at']), 'Y/m/d');
            } else {
                $week = $this->attributes['week_num'];

                $weekDays = getStartAndEndDate($week, $year);
                $startDate = $weekDays['week_start'];
                $endDate = $weekDays['week_end'];
                $title .= $week . ' [' . $startDate . ' - ' . $endDate . ']';
            }

            return $title;

        } else if ($type == REPORT_SEARCH_TYPE['all']) {
//get team
            return $this->attributes['title'];
        } else {
            return $this->attributes['title'];
        }
    }
}
