<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 10:04 AM
 */

namespace App\Services;

use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Services\Contracts\IUserTeamService;

class UserTeamService extends AbstractService implements IUserTeamService
{
    public function __construct(IUserRepository $userRepository, IUserTeamRepository $userTeamRepository)
    {
        $this->userRepository = $userRepository;
        $this->userTeamRepository = $userTeamRepository;
    }


}
