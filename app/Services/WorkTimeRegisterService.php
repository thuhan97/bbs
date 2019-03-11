<?php
/**
 * WorkTimeService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

use App\Models\WorkTimeRegister;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTimeRegisterRepository;
use App\Services\Contracts\IWorkTimeRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkTimeRegisterService extends AbstractService implements IWorkTimeRegisterService
{
    /**
     * WorkTimeService constructor.
     *
     * @param \App\Models\WorkTime $model
     * @param \App\Repositories\Contracts\IWorkTimeRepository $repository
     */
    public function __construct(WorkTimeRegister $model, IWorkTimeRegisterRepository $repository, IUserRepository $userRepository)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function search(Request $request, &$perPage, &$search)
    {
        // TODO: Implement search() method.
    }

    public function findOne($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function findOneUser($id)
    {
        return $this->userRepository->findOne($id);
    }

    public function update($id, array $payload)
    {
        try {
            DB::transaction(function () use ($payload, $id){
                foreach ($payload as $item) {
                    $this->repository->updateOrCreate([
                        'day' => $item['day'],
                        'user_id' => $id
                    ], $item);
                }
            });

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
