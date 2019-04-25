<?php

namespace App\Exports;

use App\Models\WorkTimesExplanation;
use App\Services\Contracts\IOverTimeService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OTListExport implements FromArray, WithHeadings
{
    public function __construct()
    {
        $this->overTimeService = app()->make(IOverTimeService::class);
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
        $explanations = $this->overTimeService->getListOverTime();
        $results = [];
        $i = 1;
        foreach ($explanations as $explanation) {
            $item = $this->makeRow($explanation, $i++);
            $results[] = $item;
        }
        return $results;
    }

    public function makeRow($explanation, $i)
    {
        return [
            'stt' => $i++,
            'staff_code' => $explanation->creator->staff_code,
            'creator' => $explanation->creator->name,
            'ot_type' => $explanation->ot_type == 0 ? 'Lý do cá nhân' : 'OT dự án',
            'work_day' => $explanation->work_day,
            'work_time_end_at' => $explanation->work_time_end_at ?? '** : ** : **',
            'status' => $explanation->status == 0 ? 'Chưa duyệt' : 'Đã duyệt',
            'approver' => $explanation->approver,
            'note' => $explanation->note,
        ];
    }
}
