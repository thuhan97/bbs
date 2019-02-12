<?php
namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\IProjectRepository;

/**
 * Author: jvb
 * Date: 2019/01/31 05:00
 */
class ProjectRepository extends AbstractRepository implements IProjectRepository
{
    /**
     * ProjectModel
     *
     * @var  string
     */
    protected $modelName = Project::class;

}
