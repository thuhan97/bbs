<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IUserService;
use App\Traits\RESTActions;
use App\Traits\ParseRequestSearch;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IUserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

/**
 * UserController
 * Author: trinhnv
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
        $criteria = $this->parseRequest($request);
        $collections = $this->repository->findBy($criteria);
        return $this->respondTransformer($collections);
    }

    /**
     * Get total potato
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPotato()
    {
        $total = $this->service->getPotato(Auth::id());
        return $this->respond(['total' => $total]);
    }

}
