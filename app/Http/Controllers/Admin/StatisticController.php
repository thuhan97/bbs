<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserTeam;
use App\Models\Statistics;
use App\Repositories\Contracts\IStatisticRepository;
use App\Services\Contracts\IStatisticService;
use App\Services\StatisticService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use function PHPSTORM_META\type;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_Worksheet;
use PHPExcel_Style;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;

/**
 * StatisticController
 * Author: jvb
 * Date: 2019/01/22 10:50
 * @property \app\Models\UserTeam $UserTeam
 * @property \app\Models\Statistics Statistics
 */
class StatisticController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.work_time_statistic';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::work_time_statistic';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Statistics::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Thống kê thời gian làm việc';

    protected $resourceSearchExtend = 'admin.work_time_statistic._search_extend';

    private $sevice;

    /**
     * Controller construct
     *
     * @param IStatisticRepository $repository
     * @param IStatisticService $service
     */
    public function __construct(IStatisticRepository $repository, IStatisticService $service)
    {
        $this->repository = $repository;
        $this->sevice = $service;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param int $perPage
     * @param null $search
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        return $this->sevice->search($request, $perPage, $search);
    }

    /**
     * @return string
     */
    public function getResourceIndexPath()
    {
        return 'admin.work_time_statistic.search';
    }

    /**
     * @param Request $request
     * @return Factory|Response|View
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());
        $search_type = $request->get('statistics') ? $request->get('statistics') : 1;
        $work_types = [];
        $user_team = [];
        $counts = [];
        $chart = [];
        $records = $this->searchRecords($request, $perPage, $search);
        if ($search_type == StatisticService::TYPE_ONE) {
            $chart = $this->dongusChart($request);
            $work_types = $this->arraySort($records, $sortkey = 'type', 'name');
        } elseif ($search_type == StatisticService::TYPE_TWO) {
            $work_types = $this->arraySort($records, $sortkey = 'id', 'type');
            foreach ($work_types as $index => $work_type) {
                $work_types[$index] = array_count_values($work_type);
            }
            if ($request->get('team_id')) {
                $user_team = UserTeam::getUsers($request->get('team_id'));
                $chart = $this->dongusChartTeam($request, $user_team);
            }
        } elseif ($search_type == StatisticService::TYPE_THREE) {
            $work_types = $records;
            foreach ($this->arraySort($records, $sortkey = 'type', 'type') as $index => $item) {
                $counts[$index] = array_count_values($item);
            }
            if ($request->get('user_id')) {
                $chart = $this->dongusChartUser($request, $request->get('user_id'));
            }
        }
        // wirte to session request
        $request->session()->put('search', $request->all());
        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'search' => $search,
            'chart' => $chart,
            'work_types' => $work_types,
            'user_team' => $user_team,
            'counts' => $counts,
            'request_input' => $request->all(),
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
            'resourceSearchExtend' => $this->resourceSearchExtend,
            'addVarsForView' => $this->addVarsSearchViewData()
        ]));
    }

    /**
     * @param Request $request
     * @param         $perPage
     * @param         $search
     *
     * @return LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function searchRecords(Request $request, &$perPage, &$search)
    {
        $perPage = (int)$request->input('per_page', '');
        $perPage = (is_numeric($perPage) && $perPage > 0 && $perPage <= 100) ? $perPage : DEFAULT_PAGE_SIZE;
        $search = $request->input('search', '');
        return $this->getSearchRecords($request, $perPage, $search);
    }

    /**
     * @param Request $request
     * @param null $user_id
     * @return array
     */
    public function dongusChartUser(Request $request, $user_id = null)
    {

        $months = [];
        if ($request->get('month')) {
            $months = $this->_percent(Statistics::dongusMonth($request->get('month'), [], $user_id));
        }
        return [
            'months' => $months
        ];
    }

    /**
     * @param Request $request
     * @param array $user_team
     * @return array
     */
    public function dongusChartTeam(Request $request, $user_team = [])
    {
        $months = [];
        if ($request->get('month')) {
            $months = $this->_percent(Statistics::dongusMonth($request->get('month'), $user_team, null, false));
        }
        $weeks = [];
        if ($request->get('week')) {
            $weeks = $this->_percent(Statistics::dongusWeek($request->get('week'), $user_team, null));
        }

        return [
            'months' => $months,
            'weeks' => $weeks,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function dongusChart(Request $request)
    {
        $seach_type = ($request->get('statistics')) ? $request->get('statistics') : 1;
        $months = [];
        if ($request->get('month')) {
            $months = $this->_percent(Statistics::dongusMonth($request->get('month'), [], null, false));
        }
        $weeks = [];
        if ($request->get('week')) {
            $weeks = $this->_percent(Statistics::dongusWeek($request->get('week'), []));
        }
        $dates = [];
        if ($seach_type == StatisticService::TYPE_ONE) {
            $dates = $this->_percent(Statistics::dongusDate($request->get('date'), false));
        }
        return [
            'months' => $months,
            'weeks' => $weeks,
            'dates' => $dates,
        ];
    }

    /**
     * @param array $arr
     * @return array
     */
    private function _percent($arr = [])
    {
        $total = array_sum(array_column($arr, 'amount'));
        $percent = [];
        foreach ($arr as $item) {
            $per = ($item['amount'] / $total) * 100;
            if ($per < 1 && $per != 0) {
                $per = 1;
            }
            if ($per != 0) {
                $percent[$item['type']] = $per;
            }
        }
        return $percent;
    }

    /**
     * @param $input
     * @param $sortkey
     * @param $sort_name
     * @return array
     */
    private function arraySort($input, $sortkey, $sort_name)
    {
        $output = [];
        if (!empty($input)) {
            foreach ($input as $val) $output[$val[$sortkey]][] = $val[$sort_name];
        }
        return $output;
    }


    /**
     * @param Request $request
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function export(Request $request)
    {
        if ($request->session()->has('search')) {
            $search = $request->session()->get('search');
            if (!empty($search)) {
                if ($search['statistics'] == StatisticService::TYPE_ONE) {
                    $date = $search['date'];
                    $records = Statistics::dongusDate($date, true);
                    $work_types = $this->arraySort($records, $sortkey = 'type', 'name');
                    $this->processDownload($work_types, StatisticService::TYPE_ONE, []);
                } elseif ($search['statistics'] == StatisticService::TYPE_TWO) {
                    $user_team = UserTeam::getUsers($search['team_id']);
                    $work_types = $this->arraySort(Statistics::dongusMonth($search['month'], $user_team, null, true), $sortkey = 'id', 'type');
                    foreach ($work_types as $index => $work_type) {
                        $work_types[$index] = array_count_values($work_type);
                    }
                    $this->processDownload($work_types, StatisticService::TYPE_TWO, $user_team);
                } else {
                    $work_types = Statistics::dongusMonth($search['month'], [], $search['user_id'], true);
                    $this->processDownload($work_types, StatisticService::TYPE_THREE, []);
                }
            }
        }
    }

    /**
     * @param array $arr
     * @param string $type
     * @param array $user_team
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    private function processDownload($arr = [], $type = '', $user_team = [])
    {
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Add some data
        if ($type == StatisticService::TYPE_ONE) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', STT)
                ->setCellValue('B1', ON_TIME)
                ->setCellValue('C1', LATE_EARLY)
                ->setCellValue('D1', OT)
                ->setCellValue('E1', LATE_OT)
                ->setCellValue('F1', LEAVE);
        } else if ($type == StatisticService::TYPE_TWO) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', USER_NAME)
                ->setCellValue('B1', ON_TIME)
                ->setCellValue('C1', LATE_EARLY)
                ->setCellValue('D1', OT)
                ->setCellValue('E1', LATE_OT)
                ->setCellValue('F1', LEAVE);
        } else {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', TIME_STA)
                ->setCellValue('B1', ON_TIME_USER)
                ->setCellValue('C1', LATE_EARLY_USER)
                ->setCellValue('D1', OT_USER)
                ->setCellValue('E1', LATE_OT_USER)
                ->setCellValue('F1', LEAVE);
        }
        $styleArray = array(
            'font' => array(
                //'color' => array('rgb' => 'FF0000'),
                'size' => 10,
                'name' => 'Arial'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    //'color' => array('rgb' => 'DDDDDD')
                )
            )
        );
        $rows = 2;
        if ($type == StatisticService::TYPE_ONE) {
            $row_max = max(array_map("count", $arr));
            $tableCounter = 0;
            for ($i = 0; $i < $row_max; $i++) {
                $tableCounter++;
                // Miscellaneous glyphs, UTF-8
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rows, $tableCounter)
                    ->getColumnDimension('A')
                    ->setWidth(5);
                if (isset($arr[Statistics::TYPES['normal']][$i])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $rows, $arr[Statistics::TYPES['normal']][$i])
                        ->getColumnDimension('B')
                        ->setWidth(28);
                }
                if (isset($arr[Statistics::TYPES['latey_early']][$i])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C' . $rows, $arr[Statistics::TYPES['latey_early']][$i])
                        ->getColumnDimension('c')
                        ->setWidth(28);
                }
                if (isset($arr[Statistics::TYPES['ot']][$i])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D' . $rows, $arr[Statistics::TYPES['ot']][$i])
                        ->getColumnDimension('D')
                        ->setWidth(25);
                }
                if (isset($arr[Statistics::TYPES['lately_ot']][$i])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E' . $rows, $arr[Statistics::TYPES['lately_ot']][$i])
                        ->getColumnDimension('E')
                        ->setWidth(28);
                }
                if (isset($arr[Statistics::TYPES['leave']][$i])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('F' . $rows, $arr[Statistics::TYPES['leave']][$i])
                        ->getColumnDimension('F')
                        ->setWidth(28);
                }
                $rows++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . ($row_max + 1))->applyFromArray($styleArray);
        } elseif ($type == StatisticService::TYPE_TWO) {
            foreach ($user_team as $key => $item) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rows, $item)
                    ->getColumnDimension('A')
                    ->setWidth(25);
                // normal
                if (isset($arr[$key][Statistics::TYPES['normal']])) {
                    $val = $arr[$key][Statistics::TYPES['normal']];
                } else {
                    $val = 0;
                }
                $val = $val . COUNT;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $rows, $val)
                    ->getColumnDimension('B')
                    ->setWidth(10);

                // latey_early
                if (isset($arr[$key][Statistics::TYPES['latey_early']])) {
                    $val = $arr[$key][Statistics::TYPES['latey_early']];
                } else {
                    $val = 0;
                }
                $val = $val . COUNT;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $rows, $val)
                    ->getColumnDimension('C')
                    ->setWidth(10);
                // ot
                if (isset($arr[$key][Statistics::TYPES['ot']])) {
                    $val = $arr[$key][Statistics::TYPES['ot']];
                } else {
                    $val = 0;
                }
                $val = $val . COUNT;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . $rows, $val)
                    ->getColumnDimension('D')
                    ->setWidth(10);

                // lately_ot
                if (isset($arr[$key][Statistics::TYPES['lately_ot']])) {
                    $val = $arr[$key][Statistics::TYPES['lately_ot']];
                } else {
                    $val = 0;
                }
                $val = $val . COUNT;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('E' . $rows, $val)
                    ->getColumnDimension('E')
                    ->setWidth(10);

                // leave
                if (isset($arr[$key][Statistics::TYPES['leave']])) {
                    $val = $arr[$key][Statistics::TYPES['leave']];
                } else {
                    $val = 0;
                }
                $val = $val . COUNT;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $rows, $val)
                    ->getColumnDimension('F')
                    ->setWidth(10);
                $rows++;

            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . (count($user_team) + 1))->applyFromArray($styleArray);
        } else {
            foreach ($arr as $key => $val) {
                $time = ' ' .$val['work_date'] . $val['start'] . '-' . $val['end'];
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rows, $time)
                    ->getColumnDimension('A')
                    ->setWidth(10);

                // normal
                if ($val['type'] == Statistics::TYPES['normal']) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $rows, 'x')
                        ->getColumnDimension('B')
                        ->setWidth(10);
                }

                // latey_early
                if ($val['type'] == Statistics::TYPES['latey_early']) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C' . $rows, 'x')
                        ->getColumnDimension('C')
                        ->setWidth(10);
                }

                // ot
                if ($val['type'] == Statistics::TYPES['latey_early']) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D' . $rows, 'x')
                        ->getColumnDimension('D')
                        ->setWidth(10);
                }

                // lately_ot
                if ($val['type'] == Statistics::TYPES['lately_ot']) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E' . $rows, 'x')
                        ->getColumnDimension('E')
                        ->setWidth(10);
                }
                // leave
                if ($val['type'] == Statistics::TYPES['leave']) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('F' . $rows, 'x')
                        ->getColumnDimension('F')
                        ->setWidth(10);
                }
                $rows++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('B2:F1' . (count($arr) + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . (count($arr) + 1))->applyFromArray($styleArray)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A2:A1' . (count($arr) + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setWrapText(true);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setName('Arial')->setSize(10)->setBold(true);

        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('xxx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=danhsach_' . date('Y_m_d') . '.xls');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}
