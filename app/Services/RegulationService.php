<?php
/**
 * RegulationService class
 * Author: jvb
 * Date: 2019/01/11 09:23
 */

namespace App\Services;

use App\Models\Regulation;
use App\Repositories\Contracts\IRegulationRepository;
use App\Services\Contracts\IRegulationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RegulationService extends AbstractService implements IRegulationService
{
    /**
     * RegulationService constructor.
     *
     * @param \App\Models\Regulation                            $model
     * @param \App\Repositories\Contracts\IRegulationRepository $repository
     */
    public function __construct(Regulation $model, IRegulationRepository $repository)
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
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        return $this->repository->findBy($criterias, [
            'id',
            'name',
            'approve_date',
            'created_at',
            'updated_at',
        ], true);
    }

    /**
     * @param int $id
     *
     * @return Regulation
     */
    public function detail($id)
    {
        $regulation = $this->repository->findOneBy([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ]);

        if ($regulation) {
            return $regulation;
        }
    }
}
