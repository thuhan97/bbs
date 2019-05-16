<?php

namespace App\Exports;

use App\Helpers\ExcelHelper;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

abstract class WTGridExport implements ShouldAutoSize, WithEvents
{
    protected $ignoreFormatColumns = [
        'B', 'C'
    ];

    protected $records;
    protected $firstDate;
    protected $lastDate;


    /**
     * @var array
     */
    protected $dateLists;

    protected $headings;
    protected $importList;
    protected $moreColumnNumber = 3;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        $userModel = User::select('id', 'staff_code', 'name', 'contract_type')
            ->where('status', ACTIVE_STATUS);
        $userID = $request->get('user_id', 0);
        if ($userID) {
            $this->users = $userModel
                ->where('id', $userID)
                ->get();
        } else {
            $this->users = $userModel
                ->orderBy('contract_type')
                ->orderBy('id')
                ->get();
        }

        $this->records = $records;
        [$firtDate, $lastDate] = getStartAndEndDateOfMonth($request->get('month'), $request->get('year'));
        $this->firstDate = $firtDate;
        $this->lastDate = $lastDate;
        $this->dateLists = get_date_list($this->firstDate, $this->lastDate);

    }

    protected function getHeadings(): void
    {
    }

    protected function getList(): void
    {
    }

    public function registerEvents(): array
    {
        $borderStyle = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'black'],
                ],
            ]
        ];
        $styleArray = [
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
            ,
            'font' => [
                'bold' => true
            ],

        ];
        $styleArray1 = [
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        ];

        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            },
            AfterSheet::class => function (AfterSheet $event) use ($borderStyle, $styleArray, $styleArray1) {
                $count = count($this->users) + 4;
                $length = count($this->dateLists) + $this->moreColumnNumber;
                $rows = ExcelHelper::getExcelRows($length);
                $headingFormat = array_merge($borderStyle, $styleArray);
                $workTimeFormat = array_merge($borderStyle, $styleArray1);
                $nameFormat = $borderStyle;

                foreach ($rows as $value) {
                    $event->sheet->getStyle($value . '1')->applyFromArray($headingFormat);
                    $event->sheet->getStyle($value . '2')->applyFromArray($headingFormat);
                    for ($i = 0; $count > $i; $i++) {
                        if (!in_array($value, $this->ignoreFormatColumns))
                            $event->sheet->getStyle($value . "1:" . $value . $i)->applyFromArray($workTimeFormat);
                        $event->sheet->getStyle($value . "1:" . $value . $i)->applyFromArray($nameFormat);
                    }
                }
                $event->sheet->insertNewRowBefore(DEFAULT_INSERT_ROW_EXCEL);
            },

        ];
    }
}
