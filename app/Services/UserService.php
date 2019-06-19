<?php
/**
 * UserService class
 * Author: jvb
 * Date: 2018/07/16 10:34
 */

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\Team;
use App\Models\User;
use App\Models\UserTeam;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
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
     * @param bool    $isGetAll
     *
     * @return collection
     */
    public function getContact(Request $request, &$perPage, &$search, $isGetAll = true)
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

            })->orderBy('jobtitle_id', 'desc')->orderBy('staff_code');
        if ($isGetAll) {
            return $userModels->get();
        } else {
            $perPage = $request->get('page_size', DEFAULT_PAGE_SIZE);

            return $userModels->paginate($perPage);
        }

    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUserManager()
    {
        $user = Auth::user();
        if ($user->jobtitle_id == MASTER_ROLE) {
            return collect();
        }
        if ($user->jobtitle_id == MANAGER_ROLE) {
            return $this->model->where('jobtitle_id', MASTER_ROLE)->pluck('name', 'id');
        }
        if ($user->jobtitle_id == TEAMLEADER_ROLE) {
            $team = Team::where('leader_id', Auth::id())->first();
        } else {
            $team = UserTeam::where('user_id', Auth::id())->first()->team ?? null;
        }

        if ($team) {
            $id = $team->group->manager_id;
            return $this->model->where('id', $id)->pluck('name', 'id');
        } else {
            return $this->model->where('jobtitle_id', MANAGER_ROLE)->pluck('name', 'id');
        }
    }

    public function detail($id)
    {
        return $this->repository->findOneBy([
            'id' => $id,
        ]);
    }
}
