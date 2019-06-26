<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IRegulationService;
use App\Traits\RESTActions;
use App\Transformers\RegulationTransformer;
use Illuminate\Http\Request;

class RegulationController extends Controller
{
    use RESTActions;

    /**
     * @var IRegulationService
     */
    private $regulationService;

    /**
     * RegulationController constructor.
     *
     * @param IRegulationService    $regulationService
     * @param RegulationTransformer $transformer
     */
    public function __construct(
        IRegulationService $regulationService,
        RegulationTransformer $transformer
    )
    {
        $this->regulationService = $regulationService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $regulations = $this->regulationService->search($request, $perPage, $search);
        return $this->respondTransformer($regulations);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $regulation = $this->regulationService->detail($id);
        if ($regulation != null) {
            return $this->respondTransformer($regulation);
        }
        return $this->respondNotfound();
    }

}
