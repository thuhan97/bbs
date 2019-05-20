<?php
/**
 * EventModel class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    const IS_SENT = 1;

    protected $table = 'events';

    public $autoCreator = true;

    protected $fillable = [
        'name',
        'slug_name',
        'image_url',
        'event_date',
        'event_end_date',
        'introduction',
        'content',
        'view_count',
        'has_notify',
        'notify_date',
        'is_sent',
        'place',
        'deadline_at',
        'status',
    ];

    const TIME_STATUS = [
        '1' => 'in_past',
        '0' => 'in_present',
        '-1' => 'in_feature',
    ];

    const TIME_STATUS_NAME = [
        '1' => '',
        '0' => '[Hôm nay] - ',
        '-1' => '[Sắp diễn ra] - ',
    ];

    const TIME_STATUS_CLASS = [
        '-1' => 'e8f5e9 green lighten-5',
        '0' => 'fff9c4 yellow lighten-4',
        '1' => '',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at',
    ];

    public function getEventStatusClassAttribute()
    {
        return self::TIME_STATUS_CLASS[$this->getEventStatus()];
    }

    public function getEventStatusNameAttribute()
    {
        return self::TIME_STATUS_NAME[$this->getEventStatus()];
    }

    public function getEventEndDateAttribute()
    {
        if (empty($this->attributes['event_end_date'])) {
            return $this->attributes['event_date'] ?? '';
        }
        return $this->attributes['event_end_date'];
    }

    private function getEventStatus()
    {
        return date(DATE_FORMAT) <=> $this->event_date;
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
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('slug_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('introduction', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%');
    }

    /**
     * @content has One user
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     * @author  : Hunglt
     * @Date    : 2018/09/28
     *
     */
    public function eventAttendanceList()
    {
        return $this->hasMany(EventAttendance::class, 'event_id', 'id');
    }

    public function canRegister($userId)
    {
        if ($this->attributes['deadline_at'] >= date(DATE_TIME_FORMAT)) {
            if (!$this->eventAttendanceList()->where('user_id', $userId)->exists())
                return true;
        }
        return false;
    }


}
