<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IPotatoService;
use App\Services\Contracts\IUserService;
use App\Traits\ParseRequestSearch;
use App\Traits\RESTActions;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * UserController
 * Author: jvb
 * Date: 2018/09/16 10:34
 */
class AuthController extends Controller
{
    use RESTActions;
    use ParseRequestSearch;

    /**
     * AuthController constructor.
     *
     * @param \App\Repositories\Contracts\IUserRepository $repository
     * @param \App\Services\Contracts\IUserService        $service
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
     * @param \App\Http\Requests\RegisterFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterFormRequest $request)
    {
        $user = $this->service->register($request);

        return $this->respond($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return UserResource|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!$token = JWTAuth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'errors' => [
                    'email' => ['There is something wrong! We could not verify details']
                ]], 422);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        \auth()->logout();
    }

    //AuthController
    public function refreshToken()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            $this->respondFail('Token not provided');
        }
        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            $this->respondFail('The token is invalid');
        }
        return $this->respond(['token' => $token]);
    }

    public function user(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return (new UserDetailResource($user));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $request->merge(['get_all' => true]);
        $potatos = $this->potatoService->showList(Auth::id(), $request);
        $user = User::where('id', Auth::id())
            ->with('level:id,name,introduce,image_url', 'test_histories.question_set:id,name')
            ->first();

        $data = [
            'user' => $user,
            'current_potato' => $this->potatoService->currentPotato(Auth::id()),
            'potatos' => $potatos,
        ];

        return $this->respond($data);
    }

    private function tryLogout()
    {
        try {
//            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $exception) {

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $exception) {

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $exception) {

        } catch (\Exception $exception) {

        }
    }

}
