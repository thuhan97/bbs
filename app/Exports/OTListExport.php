<?php

namespace App\Exports;

use App\Models\WorkTimesExplanation;
use App\Services\Contracts\IOverTimeService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OTListExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct($explanations)
    {
        $this->explanations = $explanations;
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
        $results = [];
        $i = 1;
        foreach ($this->explanations->get() as $explanation) {
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
            'work_day' => $explanation->work_day,
            'ot_type' => $explanation->ot_type == array_search('Dự án', OT_TYPE) ? 'OT dự án' : 'Lý do cá nhân',
            'work_time_end_at' => $explanation->work_time_end_at ?? '**:**',
            'note' => $explanation->note,
            'status' => $explanation->status == array_search('Chưa duyệt', OT_STATUS) ? 'Chưa duyệt' : 'Đã duyệt',
            'approver' => $explanation->approver,
        ];
    }
}
