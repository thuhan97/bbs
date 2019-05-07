<?php
/**
 * UserService class
 * Author: jvb
 * Date: 2018/07/16 10:34
 */

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\Potato;
use App\Models\Team;
use App\Models\User;
use App\Models\UserTeam;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Services\Contracts\IPotatoService;
use App\Services\Contracts\IUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserService extends AbstractService implements IUserService
{

    /**
     * UserService constructor.
     *
     * @param \App\Models\User                            $model
     * @param \App\Repositories\Contracts\IUserRepository $repository
     * @param IUserTeamRepository                         $userTeamRepository
     */
    public function __construct(User $model, IUserRepository $repository, IUserTeamRepository $userTeamRepository)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->userTeamRepository = $userTeamRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        $data = $request->all('email', 'password', 'name', 'invite_code');

        $data['activate_code_time'] = Carbon::now();
        $data['activate_code'] = strtoupper(str_random(4));

        $user = $this->repository->save($data);

        event(new UserRegistered($user));

        return $user;
    }

    /**
     * @param string $idCode
     *
     * @return int
     */
    public function getUserIdByIdCode(string $idCode)
    {
        $user = $this->model->where('id_code', $idCode)->first();

        return $user->id ?? 0;
    }

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function getContact(Request $request, &$perPage, &$search)
    {
        $userModels = User::where('status', ACTIVE_STATUS)
            ->where(function ($q) use ($request) {
                $search = $request->search;
                $q->search($search);
                $teams = Team::search($search)->select('teams.id', 'leader_id')->get();
                $teamIds = $teams->pluck('id')->toArray();
                $leaderIds = $teams->pluck('leader_id')->toArray();

                if (!empty($teamIds)) {
                    $userIds = UserTeam::select('user_id')
                        ->whereIn('team_id', $teamIds)
                        ->pluck('user_id')->toArray();

                    $q->orWhereIn('id', $userIds)
                        ->orWhereIn('id', $leaderIds);
                }

            });

        return $userModels->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUserManager()
    {
<<<<<<< HEAD
        return $this->model->where('jobtitle_id', '>=', MIN_APPROVE_JOB)->where('status', ACTIVE_STATUS)->where('id','<>',Auth::id())->pluck('name','id');

=======
        $userManager = $this->model->where('jobtitle_id', '>=', MIN_APPROVE_JOB)->where('status', ACTIVE_STATUS)->pluck('name', 'id');
        return $userManager;
>>>>>>> f644cb15a8be6e35a50efde31e03ce9e7e7e6a70
    }
}
