<?php
namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\IProjectRepository;

/**
 * UserRepository class
 * Author: nhung
 * Date: 2019/01/18 10:34
 */
class ProjectRepository extends AbstractRepository implements IProjectRepository
{
    /**
     * UserModel
     *
     * @var  string
     */
    protected $modelName = Project::class;
}
