<?php

namespace App\Exports;

use App\Models\CalendarOff;
use App\Models\DayOff;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;

class WorkTimeGridExport extends WTGridExport implements FromArray
{
    protected $moreColumnNumber = 4;
    private $dayoffs;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        parent::__construct($records, $request);

        $this->dayoffs = DayOff::select('*')->whereBetween('start_at', [$this->firstDate, $this->lastDate])
            ->orWhereBetween('end_at', [$this->firstDate, $this->lastDate])->get();

        $this->holidays = CalendarOff::all();

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
                if ($user->start_date > $date) {
                    $userData[] = '-';
                    continue;
                }

                $holiday = $this->holidays->where('date_off_from', '<=', $date)->where('date_off_to', '>=', $date)->first();
                if ($holiday) {
                    $userData[] = '-';
                    continue;
                }
                $workTime = $workTimes->firstWhere('work_day', $date);

                if ($workTime && $workTime->cost) {
                    $userData[] = $workTime->cost;
                } else {
                    $dayOff = $this->dayoffs->where('user_id', $user->id)->where('start_at', '>=', $date)->where('end_at', '<=', $date . '23:59:59')->first();
                    if ($dayOff && $dayOff->status == DayOff::APPROVED_STATUS) {
                        if ($dayOff->absent > 0) {
                            $userData[] = 'KL';
                        } else {
                            $userData[] = 'P';
                        }
                    } else {
                        $userData[] = '';
                    }
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

    protected function extendFormatSheet($sheet)
    {
        $sheetData = array_merge($this->headings, $this->importList);
        for ($i = 3; $this->totalRow > $i; $i++) {
            $user = $this->users->firstWhere('staff_code', $sheetData[$i - 1][2]);
            if ($user) {
                if ($user->jobtitle_id == MASTER_ROLE || $user->is_remote || $user->contract_type == CONTRACT_TYPES['internship']) {
                    continue;
                }

                foreach ($this->cols as $col) {
                    $cellValue = $sheet->getCell($col . $i)->getValue();
                    if (empty($cellValue) || $cellValue == '0.5') {
                        $sheet->getStyle($col . $i)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_YELLOW);
                    } elseif ($cellValue == 'P') {
                        $sheet->getStyle($col . $i)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_GREEN);
                    } elseif ($cellValue == 'KL') {
                        $sheet->getStyle($col . $i)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_RED);
                    }
                }
            }
        }
    }

}
