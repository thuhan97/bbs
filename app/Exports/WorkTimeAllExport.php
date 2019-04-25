<?php

namespace App\Exports;

use App\Models\User;
use App\Models\WorkTimesExplanation;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkTimeAllExport implements FromArray
    , WithHeadings
{
    private $records;

    /**
     * WorkTimeAllExport constructor.
     *
     * @param $records
     */
    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Mã nhân viên',
            'Tên nhân viên',
            'Ngày',
            'Thứ',
            'Giờ đến',
            'Giờ rời',
            'Chú thích',
            'Giải trình',
        ];
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $results = [];
        $users = new User();
        $users = $users->availableUsers()->select('id', 'name', 'staff_code')->get();
        $explainations = WorkTimesExplanation::where('work_day', '>=', $this->records->min('work_day'))
            ->where('work_day', '<=', $this->records->max('work_day'))
            ->get();
        foreach ($this->records as $idx => $worktime) {
            $user = $users->firstWhere('id', $worktime->user_id);
            $userExplains = $explainations
                ->where('user_id', $worktime->user_id)
                ->where('work_day', $worktime->work_day)
                ->pluck('note')->toArray();
            if ($user) {
                $day = date_format(new \DateTime($worktime->work_day), 'N');
                $day = $day == 7 ? 'Chủ nhật' : ($day + 1);
                $results[] = [
                    $user->staff_code,
                    $user->name,
                    $worktime->work_day,
                    $day, //thứ
                    $worktime->start_at,
                    $worktime->end_at,
                    $worktime->note,
                    implode(', ', $userExplains), //giải trình
                ];
            }
        }
        return $results;
    }
}
