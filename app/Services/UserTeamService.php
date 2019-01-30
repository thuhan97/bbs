<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 10:04 AM
 */
namespace App\Services;

use App\Models\UserTeam;
use App\Repositories\Contracts\ITeamRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserTeamRepository;
use App\Services\Contracts\ITeamService;
use App\Services\Contracts\IUserTeamService;
use Illuminate\Support\Facades\DB;

class UserTeamService extends AbstractService implements IUserTeamService
{
    public function __construct(IUserRepository $userRepository,IUserTeamRepository $userTeamRepository)
    {
        $this->userRepository = $userRepository;
        $this->userTeamRepository = $userTeamRepository;
    }

    public function getUsersAttribute(){
        return $this->userRepository->where('id',  $this->userTeamRepository->attributes['leader_id'])->first()->name;
    }

    public function getMemberTeamAttribute($id){
        return $this->userTeamRepository->getModel()->where('team_id',  $id)->get();
    }


}
