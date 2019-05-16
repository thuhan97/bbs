<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Models\Report;
use App\Models\Team;
use App\Repositories\Contracts\IReportRepository;
use App\Services\Contracts\IReportService;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use RESTActions;

    private $reportRepository;

    public function __construct(IReportService $service, IReportRepository $reportRepository)
    {
        $this->service = $service;
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (!$request->has('year'))
            $request->merge(['year' => date('Y')]);
        if (!$request->has('month'))
            $request->merge(['month' => date('n')]);

        if (!$request->has('team_id')) {
            $user = Auth::user();
            $team = $user->team();
            if ($team) {
                $teamId = $team->id;

                if (!$request->has('type')) {
                    $request->merge(['type' => 2]);
                    $request->merge(['team_id' => $teamId]);
                }
            } else {
                $teamId = 0;
            }

        } else {
            $teamId = $request->get('team_id');
        }

        $reports = $this->service->search($request, $perPage, $search);

        $teams = Team::pluck('name', 'id')->toArray();

        return view('end_user.report.index', compact('reports', 'search', 'perPage', 'data', 'teams', 'teamId'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $report = $this->getDraftReport();

        if (!$report)
            $report = $this->service->newReportFromTemplate();
        return view('end_user.report.create', compact('report'));
    }

    /**
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReport(Request $request)
    {
        return $this->respond([
            'report' => $this->service->detail($request->get('id'))
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $report = $this->service->detail($id);

        if ($report) {
            return view('end_user.report.detail', compact('report'));
        }
        abort(404);
    }

    /**
     * @param CreateReportRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveReport(CreateReportRequest $request)
    {
        $data = $request->only('status', 'choose_week', 'to_ids', 'content', 'is_new', 'is_private');
        $choose_week = $data['choose_week'];
        $reportType = REPORT_TYPE_WEEKLY;
        $reportDate = null;
        if ($choose_week == 0 || $choose_week == 1) {
            get_week_info($choose_week, $week_number);
        } else {
            $reportDate = date_create_from_format('d/m', $data['choose_week']);

            $choose_week = 0;
            $reportType = REPORT_TYPE_DAILY;
            $week_number = get_week_number($choose_week);
        }

        $data['title'] = $this->service->getReportTitle($data['choose_week']);

        $data['week_num'] = $week_number;
        $data['year'] = date('Y');
        $data['user_id'] = Auth::id();
        $data['month'] = getMonthFormWeek($week_number);
        $data['report_date'] = $reportDate;

        $report = $this->getDraftReport();
        if ($report) {
            $report->fill($data);
            $report->save();
        } else {
            $report = Report::where([
                'user_id' => Auth::id(),
                'year' => date('Y'),
                'month' => $data['month'],
                'week_num' => $week_number,
                'report_type' => $reportType,
            ])->first();
            if ($report) {
                $report->delete();
            }
            $report = new Report($data);
            $report->save();
        }
        if ($report) {
            if (!$data['is_new']) {
                flash()->success(__l('report_resent_successully'));
            } else if ($data['status'] == 0) {
                flash()->success(__l('report_drafted_successully'));
            } else {
                flash()->success(__l('report_created_successully'));
            }
        }

        return redirect(route('report'));
    }

    protected function getDraftReport()
    {
        return Report::where([
            'user_id' => Auth::id(),
            'status' => REPORT_DRAFT
        ])->orderBy('id', 'desc')->first();
    }
}
