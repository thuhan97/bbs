<?php

namespace App\Exports;

use App\Helpers\DateTimeHelper;
use App\Models\AdditionalDate;
use App\Models\Config;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;

class OTGridExport extends WTGridExport implements FromArray
{
    protected $moreColumnNumber = 6;

    private $config;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    private $additionalDates;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        $this->config = Config::first();
        $this->additionalDates = AdditionalDate::all();

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
        $row1[] = '';
        $row2 = ['#', 'Họ và tên', 'Mã nhân viên'];
        foreach ($this->dateLists as $date) {
            $row2[] = date_format(date_create($date), 'd');
        }
        $row2[] = 'Tổng số buổi';
        $row2[] = 'Tổng sô giờ';
        $row2[] = 'Tổng sô tiền';

        $headings[] = $row1;
        $headings[] = $row2;
        $this->headings = $headings;
    }

    protected function getList(): void
    {
        $results = [];
        $userIds = [];
        $rowNum = 1;
        $otTimeAt = $this->config->time_ot_early_at;
        $allTotal = 0;
        foreach ($this->users as $user) {
            $workTimes = $this->records->where('user_id', $user->id);
            $userIds[] = $user->id;
            $userData = [
                $rowNum++,
                $user->name,
                $user->staff_code,
            ];
            $count = 0;
            $totalHourUser = 0;
            foreach ($this->dateLists as $date) {

                $workTime = $workTimes->firstWhere('work_day', $date);

                if ($workTime) {
                    $count++;
                    $dateObj = date_create($date);
                    $checkIsAdditionalDate = $this->additionalDates->firstWhere('date_add', $dateObj->format(DATE_FORMAT));
                    $hour = 0;
                    //Regular date && additation date
                    if (!$this->config->work_days || ($this->config->work_days && in_array($dateObj->format('N'), $this->config->work_days)) || $checkIsAdditionalDate) {
                        if ($workTime->end_at > $otTimeAt) {
                            $hour = DateTimeHelper::getOtHour($otTimeAt, $workTime->end_at);
                        }
                    } else {
                        //weekend
                        $hour = DateTimeHelper::getOtHour($workTime->start_at, $workTime->end_at);
                    }
                    $totalHourUser += $hour;
                    $userData[] = $hour;
                } else {
                    $userData[] = '';
                }
            }
            $allTotal += $totalHourUser;
            $userData[] = $count;
            $userData[] = $totalHourUser;
            $userData[] = '';
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
            $lastRow[] = $allTotal;
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
