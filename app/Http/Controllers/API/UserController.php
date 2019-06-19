<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IUserService;
use App\Traits\ParseRequestSearch;
use App\Traits\RESTActions;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

/**
 * UserController
 * Author: jvb
 * Date: 2018/07/16 10:34
 */
class UserController extends Controller
{
    use RESTActions;
    use ParseRequestSearch;

    /**
     * UserController constructor.
     *
     * @param \App\Repositories\Contracts\IUserRepository $repository
     * @param \App\Transformers\UserTransformer           $transformer
     */
    public function __construct(
        IUserRepository $repository,
        IUserService $service,
        UserTransformer $transformer
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $collections = $this->service->getContact($request, $perPage, $search, false);
        return $this->respondTransformer($collections);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $report = $this->service->detail($id);
        if ($report != null) {
            return $this->respondTransformer($report);
        }
        return $this->respondNotfound();
    }

}
