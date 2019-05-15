<?php

namespace App\Exports;

use App\Models\Config;
use App\Models\Punishes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;

class LatelyGridExport extends WTGridExport implements FromArray
{
    private $config;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        $this->config = Config::first();
        parent::__construct($records, $request, true);
    }

    protected function getHeadings(): void
    {
        $row1 = ['', '', 'Thứ'];
        foreach ($this->dateLists as $date) {
            $row1[] = get_day_name($date, true);
        }
        $row1[] = '';
        $row1[] = '';
        $row2 = ['#', 'Họ và tên', 'Mã nhân viên'];
        foreach ($this->dateLists as $date) {
            $row2[] = date_format(date_create($date), 'd');
        }
        $row2[] = 'Tổng số buổi';
        $row2[] = 'Tổng tiền phạt';

        $headings[] = $row1;
        $headings[] = $row2;
        $this->headings = $headings;
    }

    protected function getList(): void
    {
        $results = [];
        $userIds = [];
        $rowNum = 1;
        $lateTimeMorning = $this->config->time_morning_go_late_at;
        $lateTimeAfternoon = $this->config->time_afternoon_go_late_at;

        foreach ($this->users as $user) {
            $workTimes = $this->records->where('user_id', $user->id);
            $userIds[] = $user->id;
            $userData = [
                $rowNum++,
                $user->name,
                $user->staff_code,
            ];
            $count = 0;

            foreach ($this->dateLists as $date) {
                $workTime = $workTimes->firstWhere('work_day', $date);

                if ($workTime) {
                    $count++;
                    if ($workTime->start_at < HAFT_HOUR . ':00') {
                        $userData[] = $this->subMinute($lateTimeMorning, $workTime->start_at);
                    } else {
                        $userData[] = $this->subMinute($lateTimeAfternoon, $workTime->start_at);
                    }

                } else {
                    $userData[] = '';
                }
            }
            $userData[] = $count;
            $userData[] = $this->punishes->where('user_id', $user->id)->sum('total_money');
            $results[] = $userData;
            $rowNum++;
        }
        if ($this->users->count() > 1) {
            $lastRow = ['', '', 'Tổng'];
            foreach ($this->dateLists as $date) {
                $lastRow[] = $this->records->whereIn('user_id', $userIds)
                    ->where('work_day', $date)->count();
            }
            $lastRow[] = '';
            $results[] = $lastRow;
        }
        $this->importList = $results;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return array_merge($this->headings, $this->importList);
    }

    private function subMinute($from, $to)
    {
        $start = date_create($from);
        $end = date_create($to);

        $diff = date_diff($start, $end);
        return $diff->format('%i') + 1;
    }
}