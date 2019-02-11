<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Services\Contracts\IProjectService;
use Illuminate\Http\Request;
/**
 * ProjectController
 * Author: jvb
 * Date: 2019/01/31 05:00
*/
class ProjectController extends Controller
{
    private $service;
    /**
     * Controller construct
    */
    public function __construct( IProjectService $service)
    {
        
        $this->service = $service;
    }

    public function index(Request $request){
        
        $projects = $this->service->search($request, $perPage, $search);

        return view('end_user.project.index', compact('projects', 'search', 'perPage'));
    }
    public function detail($id){
        $project = $this->service->detail($id);

        if ($project) {
            return view('end_user.project.detail', compact('project'));
        }
        abort(404);
    }

}
