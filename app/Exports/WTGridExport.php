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
    protected $weekends = [
        'T7', 'CN'
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
    protected $users;

    protected $weekendBgColor = 'FF00E400';

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
     * @var int
     */
    protected $totalRow;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $cols;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request)
    {
        [$firtDate, $lastDate] = getStartAndEndDateOfMonth($request->get('month'), $request->get('year'));

        $userModel = User::select('id', 'staff_code', 'name', 'contract_type', 'is_remote', 'jobtitle_id', 'start_date')
            ->where(function ($q) use ($lastDate) {
                $q->whereDate('start_date', '<=', $lastDate)
                    ->orWhereNull('start_date');
            })
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
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            },
            AfterSheet::class => function (AfterSheet $event) {
                $this->totalRow = count($this->users) + 4;
                $length = count($this->dateLists) + $this->moreColumnNumber;
                $this->cols = collect(ExcelHelper::getExcelCols($length));

                $this->formatSheet($event);
            },

        ];
    }

    protected function formatSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        $headingFormat = array_merge($this->borderStyle, $this->boldTextStyle, $this->textCenterStyle);
        $workTimeFormat = array_merge($this->boldTextStyle, $this->textCenterStyle);
        $cellFirst = $this->cols->first() . '1';
        $cellHeadingLast = $this->cols->last() . '2';
        $cellLast = $this->cols->last() . $this->totalRow;
        $sheet->getStyle($cellFirst . ':' . $cellHeadingLast)->applyFromArray($headingFormat);
        $rowNum = $this->totalRow - 1;

        $this->extendFormatSheet($sheet);

        foreach ($this->cols as $col) {
            $isWeekend = in_array($sheet->getCell($col . '1')->getValue(), $this->weekends);
            if ($isWeekend) {
                $sheet->getStyle($col . "1:" . $col . $rowNum)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($this->weekendBgColor);
            }
            for ($i = 0; $this->totalRow > $i; $i++) {
                if (!in_array($col, $this->ignoreFormatColumns))
                    $sheet->getStyle($col . "1:" . $col . $i)->applyFromArray($workTimeFormat);
                $sheet->getStyle($col . "1:" . $col . $i)->applyFromArray($this->borderStyle);
            }
        }
        $sheet->insertNewRowBefore(DEFAULT_INSERT_ROW_EXCEL);
    }

    protected function extendFormatSheet($sheet)
    {

    }
}
