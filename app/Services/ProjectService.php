<?php 
/**
* ProjectService class
* Author: jvb
* Date: 2019/01/31 05:00
*/

namespace App\Services;

use App\Models\Project;
use App\Services\Contracts\IProjectService;
use App\Repositories\Contracts\IProjectRepository;

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


}
