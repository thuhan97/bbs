<?php
/**
 * ProjectService class
 * Author: jvb
 * Date: 2019/01/31 05:00
 */

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\IProjectRepository;
use App\Services\Contracts\IProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProjectService extends AbstractService implements IProjectService
{
    public function __construct(Project $model, IProjectRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    public function detail($id)
    {
        $project = $this->repository->findOneBy([
            'id' => $id,
        ]);
        return $project;
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
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        return $this->repository->findBy($criterias, [
            'id',
            'name',
            'customer',
            'project_type',
            'leader_id',
            'start_date',
            'end_date',
            'status',

        ]);

    }


}
