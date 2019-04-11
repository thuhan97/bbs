<?php
/**
 * ReportService class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */

namespace App\Services;

use App\Models\Config;
use App\Models\Report;
use App\Repositories\Contracts\IReportRepository;
use App\Services\Contracts\IReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReportService extends AbstractService implements IReportService
{
    /**
     * ReportService constructor.
     *
     * @param \App\Models\Report                            $model
     * @param \App\Repositories\Contracts\IReportRepository $repository
     */
    public function __construct(Report $model, IReportRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search)
    {
        $criterias = $request->only('page', 'page_size', 'search', 'check_all', 'date_from', 'date_to', 'year', 'month');

        $isCheckAll = $criterias['check_all'] ?? false;
        $perPage = $criterias['page_size'] ?? REPORT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';
        $model = $this->model
            ->select([
                'id',
                'week_num',
                'title',
                'content',
                'created_at',
                'updated_at',
            ])
            ->where([
                'status' => ACTIVE_STATUS,
            ])
            ->search($search)
            ->orderBy('id', 'desc');

        if (!$isCheckAll) {
            $model->where('user_id', Auth::id());
        }
        if (isset($criterias['date_from'])) {
            $model->where('created_at', '>=', $criterias['date_from']);
        }
        if (isset($criterias['date_to'])) {
            $model->where('created_at', '<=', $criterias['date_to']);
        }
        if (!empty($criterias['year'])) {
            $model->where('year', $criterias['year']);
        }
        if (!empty($criterias['month'])) {
            $model->where('month', $criterias['month']);
        }
        return $model->paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return Report
     */
    public function detail($id)
    {
        $report = $this->model->where([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ])->with('user:id,name,email,avatar')->first();

        return $report;
    }

    /**
     * @return Report
     */
    public function newReportFromTemplate()
    {
        $report = new Report();
        $report->is_new = true;

        //Fill data from template
        $config = Config::firstOrNew(['id' => 1]);

        $report->title = $this->generateTitle($config->weekly_report_title);

        $report->content = $config->html_weekly_report_template;

        return $report;
    }

    /**
     * @param int $type : -1: daily report; 0:
     *
     * @return mixed
     */
    public function getReportTitle($type)
    {
        if ($type == -1) {
            return "Báo cáo ngày [" . date(DATE_FORMAT_SLASH) . "]";
        } else {
            $config = Config::firstOrNew(['id' => 1]);

            $template = $config->weekly_report_title;
            return $this->generateTitle($template, $type);
        }
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    private function generateTitle($template, $type = 0)
    {
        get_week_info($type, $week_number);
        [$firstDay, $lastDay] = get_first_last_day_in_week($type, $day);

        'Báo cáo tuần ' . get_week_info(0, $week_number);
        //1. ${staff_name}
        $result = str_replace('${staff_name}', Auth::user()->name, $template);

        //2. ${week_number}
        $result = str_replace('${week_number}', $week_number, $result);

        //3. ${d}
        $result = str_replace('${d}', date('d'), $result);

        //4. ${m}
        $result = str_replace('${m}', date('m'), $result);

        //5. ${Y}
        $result = str_replace('${Y}', date('Y'), $result);

        //6. ${first_day}
        $result = str_replace('${first_day}', $firstDay, $result);

        //7. ${last_day}
        $result = str_replace('${last_day}', $lastDay, $result);

        return $result;

    }
}
