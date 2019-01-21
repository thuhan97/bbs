<?php
/**
 * ReportService class
 * Author: trinhnv
 * Date: 2019/01/21 03:42
 */

namespace App\Services;

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
        $criterias = $request->only('page', 'page_size', 'search', 'check_all', 'date_from', 'date_to');
        $isCheckAll = $criterias['check_all'] ?? false;
        $perPage = $criterias['page_size'] ?? REPORT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';
        $model = $this->model
            ->select([
                'id',
                'week_num',
                'title',
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
}
