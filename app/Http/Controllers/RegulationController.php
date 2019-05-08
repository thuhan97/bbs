<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IRegulationService;
use Illuminate\Http\Request;

class RegulationController extends Controller
{
    /**
     * @var IRegulationService
     */
    private $service;

    public function __construct(IRegulationService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $regulations = $this->service->search($request, $perPage, $search);

        return view('end_user.regulation.index', compact('regulations', 'search', 'perPage'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $regulation = $this->service->detail($id);

        if ($regulation) {
            return view('end_user.regulation.detail', compact('regulation'));
        }
        abort(404);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function download($id)
    {
        $regulation = $this->service->detail($id);

        if ($regulation && $regulation->file_path) {
            return redirect($regulation->file_path);
        }
        abort(404);
    }
}
