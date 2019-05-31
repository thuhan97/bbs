<?php

namespace App\Exports;

use App\Helpers\DateTimeHelper;
use App\Helpers\ExcelHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class OTListExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $borderStyle = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'black'],
            ],
        ]
    ];

    protected $boldTextStyle = [
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
        ,
        'font' => [
            'bold' => true
        ],

    ];

    protected $textCenterStyle = [
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
    ];
    /**
     * @var \Illuminate\Support\Collection
     */
    private $cols;
    /**
     * @var int
     */
    private $totalRow;

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
            'Ngày',
            'Mã nhân viên',
            'Tên nhân viên',
            'Hình thức',
            'Thời gian',
            'Tên Dự án',
            'Nội dung',
            'Nội dung phản hồi',
            'Người duyệt',
            'Thời gian tính OT (h)',
            'Trạng thái',
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
            'work_day' => $overTime->work_day,
            'staff_code' => $overTime->creator->staff_code,
            'creator' => $overTime->creator->name,
            'ot_type' => $overTime->ot_type == array_search('Dự án', OT_TYPE) ? 'OT dự án' : 'Lý do cá nhân',
            'description_time' => $overTime->description_time,
            'project_name' => $overTime->project->name ?? '',
            'reason' => $overTime->reason,
            'note_respond' => $overTime->note_respond,
            'approver' => $overTime->approver->name ?? '',
            'time' => DateTimeHelper::getOtHour($overTime->start_at, $overTime->end_at),
            'status' => $overTime->status == array_search('Chưa duyệt', OT_STATUS) ? 'Chưa duyệt' : 'Đã duyệt',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            },
            AfterSheet::class => function (AfterSheet $event) {
                $this->totalRow = $this->overTimes->count() + 2;
                $length = count($this->headings());
                $this->cols = collect(ExcelHelper::getExcelCols($length));

                $this->formatSheet($event);
            },

        ];
    }

    protected function formatSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        $headingFormat = array_merge($this->borderStyle, $this->boldTextStyle, $this->textCenterStyle);
        $cellFirst = $this->cols->first() . '1';
        $cellHeadingLast = $this->cols->last() . '1';
        $sheet->getStyle($cellFirst . ':' . $cellHeadingLast)->applyFromArray($headingFormat);
        foreach ($this->cols as $col) {
            for ($i = 0; $this->totalRow > $i; $i++) {
                $sheet->getStyle($col . "1:" . $col . $i)->applyFromArray($this->borderStyle);
            }
        }
    }
}
