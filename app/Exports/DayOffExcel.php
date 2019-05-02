<?php
/**
 * DiaryListExport
 * @subpackage classExport
 * @author     LuongTuanHung
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class DayOffExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $styleArray = [
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
            ,
            'font' => [
                'bold' => true
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'black'],
                ],
            ]

        ];
        $styleArray1 = [
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'black'],
                ],
            ]

        ];
        $styleArray2 = [
            'font' => [
                'bold' => true,
                'size'=>SIZE_TEXT_EXCEL_DAY_OFF
            ],

        ];

        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            },
            AfterSheet::class => function (AfterSheet $event) use ($styleArray,$styleArray1,$styleArray2) {
                $count=count($this->data)+NUMBER_COUNT_DAY_OFF;
            $row=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            foreach ($row as $value){
                $event->sheet->getStyle($value.'1')->applyFromArray($styleArray);
                for ($i=0 ; $count > $i ; $i++){
                    $event->sheet->getStyle($value."1:".$value.$i)->applyFromArray($styleArray1);
                }
            }
                $event->sheet->insertNewRowBefore(DEFAULT_INSERT_ROW_EXCEL);
                $event->sheet->insertNewRowBefore(DEFAULT_INSERT_ROW_EXCEL);
                $event->sheet->insertNewRowBefore(DEFAULT_INSERT_ROW_EXCEL);
                $event->sheet->setCellValue('G1', 'THỐNG KÊ NGÀY NGHỈ PHÉP TRONG NĂM '.date('Y'))->getStyle('G1')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->mergeCells('G1:K1');
            },

        ];
    }
    /**
     * Function Heading
     *Ư
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
            'Ngày ký HD chính thức',
            'Số NP trong năm',
            'Số NP năm 2018 chuyển sang',
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
            'Số NN chế độ',
            'Số NP còn lại',
            'Số NP sẽ hết vào cuối năm 2018',
            'Số NP phép còn lại chuyển qua năm sau',

        ];
    }

}