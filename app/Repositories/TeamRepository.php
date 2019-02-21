<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\Contracts\ITeamRepository;

/**
 * UserRepository class
 * Author: nhung
 * Date: 2019/01/18 10:34
 */
class TeamRepository extends AbstractRepository implements ITeamRepository
{
    /**
     * UserModel
     *
     * @var  string
     */
    protected $modelName = Team::class;
}
