<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IPotatoService;
use App\Services\Contracts\IUserService;
use App\Traits\ParseRequestSearch;
use App\Traits\RESTActions;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
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
     * @var \App\Services\Contracts\IPotatoService
     */
    private $potatoService;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkActivate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->get('email'))
            ->where('is_active', User::UN_ACTIVE)
            ->whereNotNull('activate_code')
            ->first();

        return $this->respond([
            'available' => isset($user)
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'activate_code' => 'required|exists:users,activate_code'
        ]);
        $success = $this->service->active($request->only('email', 'activate_code'));

        return $this->respond($success);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->tryLogout();

        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->respondFail('Authentication failed');
        }

        $user = $this->repository->findOneBy(['email' => $request->get('email')]);
        if ($user->is_active == User::IS_ACTIVE) {
            $user->last_logged_at = Carbon::now();
            $user->save();

            $dataResponse = ['user' => $user->toArray()];
            $dataResponse['token'] = $token;

            return $this->respond($dataResponse);
        } else {
            return $this->respondAuthFail(__('messages.account_not_active'));
        }
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
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return $this->respond([
                'status' => 'success',
                'msg' => 'You have successfully logged out.'
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return
                $this->respond([
                    'status' => 'error',
                    'msg' => 'Failed to logout, please try again.'
                ], 400);
        }
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
