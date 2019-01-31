<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/31/2019
 * Time: 4:34 PM
 */

namespace App\Repositories;


use App\Repositories\Contracts\IProjectRepository;

class ProjectRepository extends AbstractRepository implements IProjectRepository
{

    protected $modelName = Project::class;
}