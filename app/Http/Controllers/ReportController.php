<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Models\Report;
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
        $reports = $this->service->search($request, $perPage, $search);

        return view('end_user.report.index', compact('reports', 'search', 'perPage', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $week_number = get_week_number();
        $report = Report::where([
            'user_id' => Auth::id(),
            'year' => date('Y'),
            'week_num' => $week_number,
        ])->first();
        if (!$report) {
            $report = $this->service->newReportFromTemplate();
        }
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
        $data = $request->only('status', 'choose_week', 'to_ids', 'content', 'title', 'is_new');
        get_week_info($data['choose_week'], $week_number);
        $data['week_num'] = $week_number;
        $data['user_id'] = Auth::id();

        $report = Report::updateOrCreate([
            'user_id' => Auth::id(),
            'year' => date('Y'),
            'week_num' => $week_number,
        ], $data);

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


}
