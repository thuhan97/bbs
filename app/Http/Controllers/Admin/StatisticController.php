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
            $months = $this->_percent(Statistics::dongusMonth($request->get('month'), $user_team, null));
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
            $months = $this->_percent(Statistics::dongusMonth($request->get('month'), []));
        }
        $weeks = [];
        if ($request->get('week')) {
            $weeks = $this->_percent(Statistics::dongusWeek($request->get('week'), []));
        }
        $dates = [];
        if ($seach_type == StatisticService::TYPE_ONE) {
            $dates = $this->_percent(Statistics::dongusDate($request->get('date')));
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
     * days_in_month($month, $year)
     * Returns the number of days in a given month and year, taking into account leap years.
     *
     * $month: numeric month (integers 1-12)
     * $year: numeric year (any integer)
     *
     * Prec: $month is an integer between 1 and 12, inclusive, and $year is an integer.
     * Post: none
     */
    private function days_in_month($month, $year)
    {
        // calculate number of days in a month
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function exprot(Request $request)
    {
        if ($request->session()->has('search')) {
            $search = $request->session()->get('search');

            print_r('<pre>');
            print_r($search);
            print_r('</pre>');
            die;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Age');
            $sheet->setCellValue('D1', 'Skills');
            $sheet->setCellValue('E1', 'Address');
            $sheet->setCellValue('F1', 'Designation');
            $rows = 2;

            foreach($employees as $empDetails){
                $sheet->setCellValue('A' . $rows, $empDetails['id']);
                $sheet->setCellValue('B' . $rows, $empDetails['name']);
                $sheet->setCellValue('C' . $rows, $empDetails['age']);
                $sheet->setCellValue('D' . $rows, $empDetails['skills']);
                $sheet->setCellValue('E' . $rows, $empDetails['address']);
                $sheet->setCellValue('F' . $rows, $empDetails['designation']);
                $rows++;
            }
            $fileName = "emp.".$type;
            if($type == 'xlsx') {
                $writer = new Xlsx($spreadsheet);
            } else if($type == 'xls') {
                $writer = new Xls($spreadsheet);
            }
            $writer->save("export/".$fileName);
            header("Content-Type: application/vnd.ms-excel");
            dd($search);
        }
    }
}
