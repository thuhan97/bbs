<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IReportService;
use App\Traits\RESTActions;
use App\Transformers\ReportTransformer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use RESTActions;

    /**
     * @var IReportService
     */
    private $reportService;

    /**
     * ReportController constructor.
     *
     * @param IReportService    $reportService
     * @param ReportTransformer $transformer
     */
    public function __construct(
        IReportService $reportService,
        ReportTransformer $transformer
    )
    {
        $this->reportService = $reportService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reports = $this->reportService->search($request, $perPage, $search);
        return $this->respondTransformer($reports);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $report = $this->reportService->detail($id);
        if ($report != null) {
            return $this->respondTransformer($report);
        }
        return $this->respondNotfound();
    }

}
