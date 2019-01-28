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
use App\Services\Contracts\IUserTeamService;

class DetailTeamService extends AbstractService implements IUserTeamService
{
    public function __construct(UserTeam $model, ITeamRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    public function getMemberTeamAttribute($id){
        return $this->model->where('team_id',  $id)->get();
    }

    public function getMemberIdAttribute(){
        return $this->model->select(['user_id'])->groupBy(['user_id'])->get();
    }
}
