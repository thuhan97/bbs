<?php
/**
 * UserService class
 * Author: jvb
 * Date: 2018/07/16 10:34
 */

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\Potato;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Services\Contracts\IPotatoService;
use App\Services\Contracts\IUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserService extends AbstractService implements IUserService
{

	/**
	 * UserService constructor.
	 *
	 * @param \App\Models\User $model
	 * @param \App\Repositories\Contracts\IUserRepository $repository
	 * @param IUserTeamRepository $userTeamRepository
	 */
    public function __construct(User $model, IUserRepository $repository,IUserTeamRepository $userTeamRepository)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->userTeamRepository= $userTeamRepository;
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
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['orders'] = ['id' => 'asc'];
        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        return $this->repository->findBy($criterias, ['*'], true);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMemberName($id){
        return $this->model->where('id',  $id)->first()->name;
    }

    public function getMemberNotInTeam($id = null){
        $memberModel = new UserTeam;
        $member = $this->userTeamRepository->getMemberIdAttribute();
//        dd($member);
        $users = '';
        $users = User::whereNotIn('id', $member)
            ->orwhere('id',$id)
            ->get();
        return $users;
    }
}
