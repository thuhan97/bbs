<?php

namespace App\Imports;

use App\Models\User;
use App\Models\WorkTime;
use App\Services\WorkTimeService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class WorkTimeImport implements ToCollection, WithValidation
{
    private $users;
    /*
     * @var WorkTimeService $workTimeService
     */
    private $workTimeService;

    const START_ROW = 3;

    const HEADINGS = [
        'staff_code' => 0,
        'date' => 4,
        'start_at' => 6,
        'end_at' => 7,
    ];

    const DEFAULT_END_AT = '17:30';
    private $startDate;
    private $endDate;

    /**
     * WorkTimeImport constructor.
     *
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate, $userIds = [])
    {
        $isAllUser = ($userIds[0] ?? null) == null;
        $userModel = User::select('id', 'staff_code', 'contract_type');
        if (!$isAllUser) {
            $userModel = $userModel->whereIn('id', $userIds);
        }

        $this->users = $userModel->pluck('id', 'staff_code', 'contract_type')->toArray();

        $this->workTimeService = app()->make(WorkTimeService::class);

        $this->workTimeService->deletes($startDate, $endDate, $isAllUser, $userIds);

        $this->startDate = date_create($startDate, new \DateTimeZone('UTC'));
        $this->endDate = date_create($endDate, new \DateTimeZone('UTC'));
    }

    /**
     * @param Collection $rows
     *
     * @throws \Exception
     */
    public function collection(Collection $rows)
    {
        $datas = [];
        foreach ($rows as $index => $row) {
            if ($index >= self::START_ROW) {
                $item = $this->readRow($row);

                if ($item) {
                    $datas[] = $item;
                }
            }
        }
        $dataCollection = collect($datas)->groupBy('user_id');
        $workDayDatas = [];
        foreach ($dataCollection as $userId => $items) {
            $workDays = $items->groupBy('work_day');
            foreach ($workDays as $day => $checkIns) {
                $times = [];
                foreach ($checkIns as $time) {
                    $times[] = $time['start_at'];
                    $times[] = $time['end_at'];
                }
                $timeColection = collect($times);

                $workDayData = [
                    'user_id' => $userId,
                    'staff_code' => $items->first()['staff_code'],
                    'work_day' => $day,
                    'start_at' => $timeColection->min(),
                    'end_at' => $timeColection->max(),
                ];

                $workDayDatas[] = $workDayData;
            }
        }
        $results = [];

        foreach ($workDayDatas as $index => $row) {
            $item = $this->mappingData($row);
            if ($item) {
                $results[] = $item;
                if ($index % 100 === 0) {
                    $this->insertData($results);
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
     * @throws \Exception
     */
    private function readRow(collection $row)
    {
        $staffCode = $row[self::HEADINGS['staff_code']];
        if (array_key_exists($staffCode, $this->users)) {

            $userId = $this->users[$staffCode];
            $startAt = $row[self::HEADINGS['start_at']];
            $endAt = $row[self::HEADINGS['end_at']];

            $work_day = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::HEADINGS['date']])->format(DATE_FORMAT);

            return [
                'user_id' => $userId,
                'staff_code' => $staffCode,
                'work_day' => $work_day,
                'start_at' => $startAt,
                'end_at' => $endAt,
            ];
        }
    }

    /**
     * @param Collection $row
     *
     * @return array
     * @throws \Exception
     */
    private function mappingData(array $row)
    {

        $staffCode = $row['staff_code'];
        if (array_key_exists($staffCode, $this->users)) {

            $startAt = $row['start_at'];
            $endAt = $row['end_at'];
            $work_day = date_create_from_format(DATE_FORMAT, $row['work_day']);
            if ($this->startDate <= $work_day && $this->endDate >= $work_day) {
                return $this->workTimeService->importWorkTime($this->users, $staffCode, $work_day, $startAt, $endAt);
            }

        }
    }

    /**
     * @param $data
     */
    private function insertData(&$data)
    {
        if (!empty($data)) {
            WorkTime::insertAll($data);
            $data = [];
        }
    }


}
