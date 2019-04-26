<?php
/**
 * DiaryListExport
 * @subpackage classExport
 * @author     LuongTuanHung
 */

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class DayOffExcel implements FromCollection, WithHeadings,ShouldAutoSize,WithEvents
{
    public $data;
    /**
     * DiaryListExport constructor.
     *
     * @param string $filename
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * function get data patient and diary export CSV
     *
     * @create_date 2018/09/18
     * @author HungLT
     * @return array
     */
    public function Collection()
    {
        return collect($this->data);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:Y1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }

    /**
     * Function Heading
     *
     * @create_date: 2018/08/27
     * @author     : Tiennm
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'Họ và Tên',
            'Mã Nhân viên',
            'Giới tính ',
            'NV Part-time',
            'Ngày vào công ty',
            'Ngày ký hợp đồng chính thức',
            'Số ngày phép trong năm',
            'Số ngày phép năm 2018 chuyển sang',
            'Tháng 1',
            'Tháng 2',
            'Tháng 3',
            'Tháng 4',
            'Tháng 5',
            'Tháng 6',
            'Tháng 7',
            'Tháng 8',
            'Tháng 9',
            'Tháng 10',
            'Tháng 11',
            'Tháng 12',
            'Tổng',
            'Số ngày nghỉ chế độ',
            'Số ngày phép còn lại',
            'Số ngày phép sẽ hết vào cuối năm 2018',
            'Số ngày phép còn lại chuyển qua năm sau',

        ];
    }


}