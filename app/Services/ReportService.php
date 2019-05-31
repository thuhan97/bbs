<?php
/**
 * ReportService class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */

namespace App\Services;

use App\Helpers\DatabaseHelper;
use App\Models\Config;
use App\Models\Group;
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
        $criterias = $request->only('page', 'page_size', 'search', 'type', 'date_from', 'date_to', 'year', 'month', 'team_id');
        $currentUser = Auth::user();

        $perPage = $criterias['page_size'] ?? REPORT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';
        $model = $this->model
            ->select([
                'id',
                'user_id',
                'week_num',
                'to_ids',
                'title',
                'status',
                'content',
                'report_type',
                'report_date',
                'color_tag',
                'created_at',
                'updated_at',
            ])
            ->where(function ($q) use ($currentUser) {
                $q->where('status', ACTIVE_STATUS)
                    ->orWhere(function ($p) use ($currentUser) {
                        $p->where('status', REPORT_DRAFT)->where('user_id', $currentUser->id);
                    });
            })
            ->search($search)
            ->with(['receivers' => function ($q) {
                $q->select('users.id', 'users.name', 'avatar')->orderBy('jobtitle_id', 'desc');
            }, 'reportReplies' => function ($q) {
                $q->orderBy('report_reply.id', 'desc');
            }])
            ->orderBy('id', 'desc');

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
        $model->where(function ($modelInner) use ($request, $criterias, $currentUser) {

            $type = $request->get('type');

            if (isset($type)) {
                if ($type == REPORT_SEARCH_TYPE['private']) {
                    $modelInner->where('user_id', Auth::id());
                } elseif ($type == REPORT_SEARCH_TYPE['team']) {
                    if (isset($criterias['team_id'])) {
                        $modelInner->where('team_id', $criterias['team_id']);
                    }
                } else {
                    //all
                }

            }
            if ($type != REPORT_SEARCH_TYPE['private']) {
                if ($currentUser->isMaster()) {
                } else if ($currentUser->isGroupManager()) {
                    $groupManage = Group::where('manager_id', $currentUser->id)->first();
                    if ($groupManage) {
                        $groupId = $groupManage->id;

                        $modelInner->where(function ($q) use ($groupId) {
                            $q->where('is_private', REPORT_PUBLISH)->orWhere('group_id', $groupId);
                        });
                    }
                } else {
                    $team = $currentUser->team();
                    if ($team) {
                        $modelInner->where(function ($q) use ($type, $team, $currentUser) {
                            $q->where('is_private', REPORT_PUBLISH)
                                ->orWhere(function ($p) use ($team) {
                                    $p->where('is_private', REPORT_PRIVATE)
                                        ->where('team_id', $team->id);
                                });

                            if ($type == REPORT_SEARCH_TYPE['all']) {
                                $q->orWhere(function ($p) use ($currentUser) {
                                    $p->where('user_id', $currentUser->id);
                                });
                            }
                        });
                    } else {
                        $modelInner->where('is_private', REPORT_PUBLISH);
                    }
                }
            }
            if (!$currentUser->isMaster()) {
                if (!($type == REPORT_SEARCH_TYPE['team'] && isset($criterias['team_id']))) {
                    $modelInner->orWhereHas('reportReceivers', function ($q) use ($currentUser) {
                        $q->where('user_id', $currentUser->id);
                    });
                }
            }
        });
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
        if ($type == 0 || $type == 1) {
            $config = Config::firstOrNew(['id' => 1]);

            $template = $config->weekly_report_title;

            return $this->generateTitle($template, $type);
        } else {
            return "Báo cáo ngày [" . $type . "]: " . Auth::user()->name;
        }
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    private function generateTitle($template, $type = 0)
    {
        [$firstDay, $lastDay] = get_first_last_day_in_week($type, $day);

        'Báo cáo tuần ' . get_week_info($type, $week_number);
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
