<?php
/**
 * UserService class
 * Author: trinhnv
 * Date: 2018/07/16 10:34
 */

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\Potato;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IPotatoService;
use App\Services\Contracts\IUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserService extends AbstractService implements IUserService
{

    /**
     * UserService constructor.
     *
     * @param \App\Models\User                            $model
     * @param \App\Repositories\Contracts\IUserRepository $repository
     */
    public function __construct(User $model, IUserRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * get total potato
     *
     * @param $user_id
     *
     * @return int
     */
    public function getPotato($user_id)
    {
        return Potato::where('user_id', $user_id)
            ->where('expire_at', '>', Carbon::now())
            ->sum('available');
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
     * @param $token
     *
     * @return bool
     */
    public function active($data)
    {
        $user = $this->repository->findOneBy([
            'email' => $data['email'],
            'activate_code' => $data['activate_code'],
            'is_active' => User::UN_ACTIVE,
        ]);
        if ($user) {
            $activateTime = $user->activate_code_time;
            if (Carbon::now()->subDay()->toDateTimeString() <= $activateTime) {
                $user->activate_code = null;
                $user->activate_code_time = null;
                $user->is_active = User::IS_ACTIVE;

                if (!empty($user['invite_code'])) {
                    //Add potato to introducer
                    $potatoService = app()->make(IPotatoService::class);
                    $potatoService->addPotato(Potato::TYPES['invite'], $user->id, INVITE_POTATO);
                }
                $user->save();

                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'token is expired'
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'user not found'
        ];
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
}
