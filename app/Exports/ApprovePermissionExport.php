<?php

namespace App\Exports;

use App\Helpers\DateTimeHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApprovePermissionExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct($approvePermissions)
    {
        $this->approvePermissions = $approvePermissions;
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
            'Giờ đến công ty',
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
        foreach ($this->approvePermissions as $approvePermission) {
            $item = $this->makeRow($approvePermission, $i++);
            $results[] = $item;
        }
        return $results;
    }



    public function makeRow($approvePermission, $i)
    {
        return [
            'stt' => $i++,
            'staff_code' => $approvePermission->creator->staff_code,
            'creator' => $approvePermission->creator->name,
            'work_day' => $approvePermission->work_day,
            'work_time_start_at' => DateTimeHelper::workTime($approvePermission['user_id'],$approvePermission['work_day'])[0],
            'work_time_end_at' => DateTimeHelper::workTime($approvePermission['user_id'],$approvePermission['work_day'])[1],
            'note' => $approvePermission->note,
            'status' => $approvePermission->status == array_search('Chưa duyệt', OT_STATUS) ? 'Chưa duyệt' : 'Đã duyệt',
            'approver' => $approvePermission->approver->name ?? '',
        ];
    }
}
