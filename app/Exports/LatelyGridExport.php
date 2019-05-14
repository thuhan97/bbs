<?php

namespace App\Exports;

use App\Models\Config;
use App\Models\Punishes;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;

class LatelyGridExport implements FromArray
{
    private $config;
    private $records;
    private $firstDate;
    private $lastDate;
    /**
     * @var array
     */
    private $dateLists;

    private $headings;
    private $importList;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records)
    {
        $this->config = Config::first();
        $this->records = $records;
        $this->firstDate = $records->min('work_day');
        $this->lastDate = $records->max('work_day');

        $this->users = User::select('id', 'staff_code', 'name')
            ->where('status', ACTIVE_STATUS)
            ->orderBy('contract_type')
            ->orderBy('id')
            ->get();
        $this->punishes = Punishes::where('infringe_date', '>=', $this->firstDate)
            ->where('infringe_date', '<=', $this->lastDate)
            ->where('rule_id', LATE_RULE_ID)
            ->get();

        $this->dateLists = get_date_list($this->firstDate, $this->lastDate);

        $this->getHeadings();
        $this->getList();
    }

    private function getHeadings()
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

    private function getList()
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
            $userData[] = number_format($this->punishes->where('user_id', $user->id)->sum('total_money'));
            $results[] = $userData;
            $rowNum++;
        }
        $lastRow = ['', '', 'Tổng'];
        foreach ($this->dateLists as $date) {
            $lastRow[] = $this->records->whereIn('user_id', $userIds)
                ->where('work_day', $date)->count();
        }
        $lastRow[] = '';
        $results[] = $lastRow;

        $this->importList = $results;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->headings + $this->importList;
    }

    private function subMinute($from, $to)
    {
        $start = date_create($from);
        $end = date_create($to);

        $diff = date_diff($start, $end);
        return $diff->format('%i') + 1;
    }
}