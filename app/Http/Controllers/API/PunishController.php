<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IPunishesService;
use App\Traits\RESTActions;
use App\Transformers\PunishesTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PunishController extends Controller
{
    use RESTActions;

    /**
     * @var IPunishesService
     */
    private $punishesService;

    /**
     * PunishesController constructor.
     *
     * @param IPunishesService    $punishesService
     * @param PunishesTransformer $transformer
     */
    public function __construct(
        IPunishesService $punishesService,
        PunishesTransformer $transformer
    )
    {
        $this->punishesService = $punishesService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $punishess = $this->punishesService->search($request, Auth::id(), $perPage, $search);
        return $this->respondTransformer($punishess);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $punishes = $this->punishesService->detail($id);
        if ($punishes != null) {
            return $this->respondTransformer($punishes);
        }
        return $this->respondNotfound();
    }

}
