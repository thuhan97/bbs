<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\User;
use App\Models\WorkTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class WorkTimeImport implements ToCollection, WithValidation
{
    private $config;
    private $users;

    const START_ROW = 3;

    const HEADINGS = [
        'staff_code' => 0,
        'date' => 4,
        'start_at' => 6,
        'end_at' => 7,
    ];

    const DEFAULT_END_AT = '17:30';

    public function __construct()
    {
        $this->config = Config::first();
        $this->users = User::pluck('id', 'staff_code')->toArray();

    }

    public function collection($rows)
    {
        $results = [];
        foreach ($rows as $index => $row) {
            if ($index >= self::START_ROW) {
                $item = $this->mappingData($row);
                if ($item) {
                    $results[] = $item;

                    if ($index % 1000 === 0) {
                        $this->insertData($results);
                    }
                }
            }
        }
        $this->insertData($results);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        // TODO: Implement rules() method.
    }

    /**
     * @param Collection $row
     *
     * @return array
     */
    private function mappingData(collection $row)
    {
        $staffCode = $row[self::HEADINGS['staff_code']];
        if (array_key_exists($staffCode, $this->users)) {

            $startAt = $row[self::HEADINGS['start_at']];
            $endAt = $row[self::HEADINGS['end_at']];

            if ($startAt || $endAt) {
                $work_day = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::HEADINGS['date']]);
                $workTime = $this->getWorkTime($work_day, $startAt, $endAt);
                $workTime['user_id'] = $this->users[$staffCode];
                $workTime['work_day'] = $work_day->format(DATE_FORMAT_SLASH);

                return $workTime;
            }

        }
    }

    /**
     * @param $startAt
     * @param $endAt
     *
     * @return array
     */
    private function getWorkTime($date, $startAt, $endAt)
    {
//        if ($endAt == null) $endAt = self::DEFAULT_END_AT;
        $note = null;
        $type = 0;
        if (($this->config->work_days && in_array($date->format('N'), $this->config->work_days)) || !$this->config->work_days) {
            if ($startAt) {
                if ($this->config->time_afternoon_go_late_at && $startAt >= $this->config->time_afternoon_go_late_at) {
                    $note = 'Đi muộn buổi chiều';
                    $type = WorkTime::TYPES['lately'];
                } else if ($this->config->time_morning_go_late_at && $startAt >= $this->config->time_morning_go_late_at) {
                    $note = 'Đi muộn buổi sáng';
                    $type = WorkTime::TYPES['lately'];
                }
            }
            if ($endAt) {
                if ($this->config->morning_end_work_at && $endAt <= $this->config->morning_end_work_at) {
                    $note = 'Về sớm buổi sáng';
                    $type = WorkTime::TYPES['early'];
                } else if ($this->config->afternoon_end_work_at && $endAt <= $this->config->afternoon_end_work_at) {
                    $note = 'Về sớm buổi chiều';
                    $type = WorkTime::TYPES['early'];
                } else if ($this->config->time_ot_early_at && $endAt >= $this->config->time_ot_early_at) {
                    $note = 'Overtime';
                    $type = WorkTime::TYPES['ot'];
                }
            }
        } else {
            $note = 'Overtime';
            $type = WorkTime::TYPES['ot'];
        }
        //
        return [
            'start_at' => $startAt,
            'end_at' => $endAt,
            'note' => $note,
            'type' => $type,
        ];
    }

    /**
     * @param $data
     */
    private function insertData(&$data)
    {
        if (!empty($data)) {
            \DB::table('work_times')->insert($data);
            $data = [];
        }
    }


}
