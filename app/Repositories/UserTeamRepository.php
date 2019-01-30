<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 11:37 AM
 */

namespace App\Repositories;


use App\Models\UserTeam;

use App\Repositories\Contracts\IUserTeamRepository;

class UserTeamRepository extends AbstractRepository implements IUserTeamRepository
{
    protected $modelName = UserTeam::class;
}