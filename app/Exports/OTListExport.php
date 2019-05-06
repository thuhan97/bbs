<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OTListExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct($overTimes)
    {
        $this->overTimes = $overTimes;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'Mã nhân viên',
            'Tên nhân viên',
            'Ngày',
            'Hình thức',
            'Giờ rời công ty',
            'Giải trình',
            'Trạng thái phê duyệt',
            'Người duyệt',
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function array(): array
    {
        $results = [];
        $i = 1;
        foreach ($this->overTimes as $overTime) {
            $item = $this->makeRow($overTime, $i++);
            $results[] = $item;
        }
        return $results;
    }



    public function makeRow($overTime, $i)
    {
        return [
            'stt' => $i++,
            'staff_code' => $overTime->creator->staff_code,
            'creator' => $overTime->creator->name,
            'work_day' => $overTime->work_day,
            'ot_type' => $overTime->ot_type == array_search('Dự án', OT_TYPE) ? 'OT dự án' : 'Lý do cá nhân',
            'work_time_end_at' => \App\Helpers\DateTimeHelper::getTimeCheckOut($overTime['user_id'],$overTime['work_day']),
            'note' => $overTime->note,
            'status' => $overTime->status == array_search('Chưa duyệt', OT_STATUS) ? 'Chưa duyệt' : 'Đã duyệt',
            'approver' => $overTime->approver->name ?? '',
        ];
    }
}
