<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repositories\Contracts\IProjectRepository;
use App\Traits\Controllers\ResourceController;
use App\Services\Contracts\IProjectService;

/**
 * ProjectController
 * Author: jvb
 * Date: 2019/01/31 05:00
*/
class ProjectController extends Controller
{
    use ResourceController;

    /**
     * @var  string
    */
    protected $resourceAlias = 'admin.projects';

    /**
     * @var  string
    */
    protected $resourceRoutesAlias = 'admin::projects';

    /**
     * Fully qualified class name
     *
     * @var  string
    */
    protected $resourceModel = Project::class;

    /**
     * @var  string
    */
    protected $resourceTitle = 'Project';
    

    /**
     * Controller construct
    */
    public function __construct(IProjectRepository $repository, IProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(){
        $projects= Project::all();
        $count=count($projects);
        return view('end_user.project.index',compact('projects','count'));
    }
    public function detail($id){
        $project = $this->service->detail($id);

        if ($project) {
            return view('end_user.project.detail', compact('project'));
        }
        abort(404);
    }

}
