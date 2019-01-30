<?php
/**
 * DayOffService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

use App\Models\DayOff;
use App\Repositories\Contracts\IDayOffRepository;
use App\Services\Contracts\IDayOffService;
use Illuminate\Http\Request;

class DayOffService extends AbstractService implements IDayOffService
{
	/**
	 * DayOffService constructor.
	 *
	 * @param \App\Models\DayOff $model
	 * @param \App\Repositories\Contracts\IDayOffRepository $repository
	 */
	public function __construct(DayOff $model, IDayOffRepository $repository)
	{
		$this->model = $model;
		$this->repository = $repository;
	}

	/**
	 * @param Request $request
	 * @param array $moreConditions
	 * @param array $fields
	 * @param string $search
	 * @param int $perPage
	 *
	 * @return mixed
	 */
	public function findList(Request $request, $moreConditions = [], $fields = ['*'], &$search = '', &$perPage = DEFAULT_PAGE_SIZE)
	{
		$criterias = $request->only('page', 'per_page', 'search', 'year', 'month', 'approve');
		$perPage = $criterias['per_page'] ?? DEFAULT_PAGE_SIZE;
		$search = $criterias['search'] ?? '';

		$isApprove = $criterias['approve'] ?? null;
		$isApprove = $isApprove !== null ? (int) $isApprove : null;
		if ($isApprove === 1) { //approved
			$moreConditions['day_offs.status'] = DayOff::APPROVED_STATUS;
		} else if ($isApprove === 0) { // not approved
			$moreConditions['day_offs.status'] = DayOff::NOTAPPROVED_STATUS;
		}

		$model = $this->model
			->select($fields)
			->with('approval')
			->where($moreConditions)
			->search($search)
			->orderBy('id');

		$year = $criterias['year'] ?? null;

		if ($year != null) {
			$model->whereYear('start_at', $year);
		}

		$month = $criterias['month'] ?? null;
		if ($month != null) {
			$model->whereMonth('start_at', $month);
		}

		return $model->paginate($perPage);
	}

	/**
	 * @param $userId
	 *
	 * @return array
	 */
	public function getDayOffUser($userId)
	{
		$model = $this->model->where('user_id', $userId)->where('status', DayOff::APPROVED_STATUS);
		$thisYear = (int)date('Y');
		return [$model->whereYear('start_at', $thisYear)->sum('number_off'), $model->whereYear('start_at', $thisYear - 1)->sum('number_off')];
	}
}
