<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IProjectService;
use App\Traits\RESTActions;
use App\Transformers\ProjectTransformer;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use RESTActions;

    /**
     * @var IProjectService
     */
    private $projectService;

    /**
     * ProjectController constructor.
     *
     * @param IProjectService    $projectService
     * @param ProjectTransformer $transformer
     */
    public function __construct(
        IProjectService $projectService,
        ProjectTransformer $transformer
    )
    {
        $this->projectService = $projectService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $projects = $this->projectService->search($request, $perPage, $search);
        return $this->respondTransformer($projects);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $project = $this->projectService->detail($id);
        if ($project != null) {
            return $this->respondTransformer($project);
        }
        return $this->respondNotfound();
    }

}
