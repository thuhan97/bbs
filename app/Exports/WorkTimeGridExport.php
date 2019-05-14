<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;

class WorkTimeGridExport implements FromArray
{
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
        $this->users = User::select('id', 'staff_code', 'name')
            ->where('status', ACTIVE_STATUS)
            ->get();
        $this->records = $records;
        $this->firstDate = $records->min('work_day');
        $this->lastDate = $records->max('work_day');
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
        $row2 = ['#', 'Họ và tên', 'Mã nhân viên'];
        foreach ($this->dateLists as $date) {
            $row2[] = date_format(date_create($date), 'd');
        }
        $row2[] = 'Tổng';

        $headings[] = $row1;
        $headings[] = $row2;
        $this->headings = $headings;
    }

    private function getList()
    {
        $results = [];
        $userIds = [];
        $rowNum = 1;
        foreach ($this->users as $user) {
            $workTimes = $this->records->where('user_id', $user->id);
            $userIds[] = $user->id;
            $userData = [
                $rowNum++,
                $user->name,
                $user->staff_code,
            ];
            foreach ($this->dateLists as $date) {
                $workTime = $workTimes->firstWhere('work_day', $date);

                if ($workTime && $workTime->cost) {
                    $userData[] = $workTime->cost;

                } else {
                    $userData[] = '';
                }
            }
            $userData[] = $workTimes->sum('cost');
            $results[] = $userData;
            $rowNum++;
        }
        $lastRow = ['', '', 'Tổng'];
        foreach ($this->dateLists as $date) {
            $lastRow[] = $this->records->whereIn('user_id', $userIds)
                ->where('cost', '>', 0)
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
}
