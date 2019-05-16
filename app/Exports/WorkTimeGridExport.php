<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;

class WorkTimeGridExport extends WTGridExport implements FromArray
{
    protected $moreColumnNumber = 4;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        parent::__construct($records, $request);

        $this->getHeadings();
        $this->getList();
    }

    protected function getHeadings(): void
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

    protected function getList(): void
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

        if ($this->users->count() > 1) {
            $lastRow = ['', '', 'Tổng'];
            foreach ($this->dateLists as $date) {
                $lastRow[] = $this->records->whereIn('user_id', $userIds)
                    ->where('cost', '>', 0)
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
}
