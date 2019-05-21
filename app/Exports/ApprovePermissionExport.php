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
            'Mã nhân viên',
            'Tên nhân viên',
            'Ngày',
            'Hình thức',
            'Giải trình',
            'Nội dung phản hồi',
            'Người duyệt',
            'Trạng thái phê duyệt',
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function array(): array
    {
        $results = [];
        foreach ($this->approvePermissions as $approvePermission) {
            $item = $this->makeRow($approvePermission);
            $results[] = $item;
        }
        return $results;
    }



    public function makeRow($approvePermission)
    {
        return [
            'staff_code' => $approvePermission->creator->staff_code,
            'creator' => $approvePermission->creator->name,
            'work_day' => $approvePermission->work_day,
            'type' => $approvePermission->type == array_search('Đi muộn',WORK_TIME_TYPE) ? 'Đi muộn' : $approvePermission->type == array_search('Về sớm',WORK_TIME_TYPE) ? 'Về sớm' : '',
            'note' => $approvePermission->note,
            'reason_reject' => $approvePermission->reason_reject,
            'approver' => $approvePermission->approver->name ?? '',
            'status' => $approvePermission->status == array_search('Chưa duyệt', OT_STATUS) ? 'Chưa duyệt' : 'Đã duyệt',
        ];
    }
}
