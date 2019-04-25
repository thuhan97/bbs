<?php

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Support\Facades\DB;

class Statistics extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'work_times';

    protected $fillable = [
        'id',
        'user_id',
        'work_day',
        'start_at',
        'end_at',
        'note',
    ];

    const TYPE_NAMES = [
        0 => 'Bình thường',
        1 => 'Đi muộn',
        2 => 'Về sớm',
        3 => 'Overtime',
    ];

    const TYPES = [
        'normal' => 0,
        'lately' => 1,
        'early' => 2,
        'ot' => 4,
        'lately_ot' => 5,
        'latey_early' => 3,
        'leave' => -1,
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhere('work_day', 'like', '%' . $searchTerm . '%')->orWhere('note', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('users.id', $searchTerm)
                ->orWhere('users.staff_code', 'like', '%' . $searchTerm . '%');
        })
            ->join('users', 'users.id', 'user_id')
            ->select('work_times.type', 'users.id', 'users.name',
                DB::raw("DATE_FORMAT(work_times.start_at, '%H:%i') as start"),
                DB::raw("DATE_FORMAT(work_times.end_at, '%H:%i') as end"),
                DB::raw("DATE_FORMAT(work_times.work_day, '%d/%m/%Y') as work_date"))
            ->orderBy('work_times.work_day', 'desc')->get()->toArray();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);//->where('status', ACTIVE_STATUS);
    }

    /**
     * @param $query
     * @param string $week
     * @param array $user_team
     * @return mixed
     */
    public function scopedongusWeek($query, $week = '', $user_team = [])
    {
        $model = $query;
        // week
        if ($week != '') {
            $explode = explode(' - ', $week);
            foreach ($explode as $index => $item) {
                $item = explode('/', $item);
                $item = implode('-', array_reverse($item, true));
                $explode[$index] = $item;
            }
            if (isset($explode[0])) {
                $model = $model->whereDate('work_day', '>=', $explode[0]);
            }
            if (isset($explode[1])) {
                $model = $model->whereDate('work_day', ' <= ', $explode[1]);
            }
        }

        if (!empty($user_team)) {
            $model = $model->whereIn('user_id', array_keys($user_team));
        }

        $model = $model->whereNotIn('type', [1, 2]);
        $model->selectRaw('count(*) as amount, work_times.type')->groupBy('work_times.type');
        return $model->get()->toArray();
    }

    /**
     * @param $query
     * @param string $month
     * @param array $user_team
     * @param null $user_id
     * @param bool $export_flag
     * @return mixed
     */
    public function scopedongusMonth($query, $month = '', $user_team = [], $user_id = null, $export_flag = false)
    {
        $model = $query;
        if ($month != '') {
            $model = $model->whereMonth('work_day', $month);
        }
        if (!empty($user_team)) {
            $model = $model->whereIn('user_id', array_keys($user_team));
        }
        if ($user_id) {
            $model = $model->where('user_id', $user_id);
        }
        $model = $model->whereNotIn('type', [1, 2]);
        if ($export_flag) {
            $model->join('users', 'users.id', 'user_id');
            $model->select('work_times.type', 'users.id', 'users.name',
                DB::raw("DATE_FORMAT(work_times.start_at, '%H:%i') as start"),
                DB::raw("DATE_FORMAT(work_times.end_at, '%H:%i') as end"),
                DB::raw("DATE_FORMAT(work_times.work_day, '%d/%m/%Y') as work_date"))->orderBy('work_times.work_day', 'desc');
//            $model->selectRaw('work_times.*, users.name')->orderBy('work_times.work_day', 'desc');
        } else {
            $model->selectRaw('count(*) as amount, work_times.type')->groupBy('work_times.type');
        }
        return $model->get()->toArray();
    }

    /**
     * @param $query
     * @param string $date
     * @param bool $export_flag
     * @return mixed
     */
    public function scopedongusDate($query, $date = '', $export_flag = false)
    {
        $model = $query;
        $model = $model->whereNotIn('type', [1, 2]);
        // date
        if ($date != '') {
            $date = explode('/', $date);
            $item = implode('-', array_reverse($date, true));
            $model = $model->whereDate('work_day', $item);
        } else {
            $model = $model->whereDate('work_day', date('Y-m-d'));
        }
        if ($export_flag) {
            $model->join('users', 'users.id', 'user_id');
            $model->selectRaw('work_times.*, users.name')->orderBy('work_times.work_day', 'desc');
        } else {
            $model->selectRaw('count(*) as amount, work_times.type')->groupBy('work_times.type');
        }
        return $model->get()->toArray();
    }

}
