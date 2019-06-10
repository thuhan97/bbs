<?php

namespace App\Http\Controllers;

use App\Events\ProjectNotify;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\Contracts\IProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function __construct(IProjectService $service)
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
        $projects = $this->service->search($request, $perPage, $search);

        return view('end_user.project.index', compact('projects', 'search', 'perPage'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $record = new Project();
        return view('end_user.project.create', compact('record'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(CreateProjectRequest $request)
    {
        $all = $request->all();
        if ($request->has('image_upload')) {
            $imageUrl = $request->file('image_upload')->store(PROJECT_IMAGE_FOLDER, 'uploads');
            $all['image_url'] = '/uploads/' . $imageUrl;
        }

        $project = new Project();
        $project->leader_id = Auth::id();
        $project->fill($all);
        $project->save();
        if ($project){
            $idUsers=User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
            broadcast(new ProjectNotify($project,$idUsers))->toOthers();

        }
        flash()->success(__l('project_add_successully'));

        return redirect(route('project'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        $record = Project::find($id);
        if ($record && $user->can('edit', $record))
            return view('end_user.project.update', compact('record'));

        abort(404);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(CreateProjectRequest $request, $id)
    {
        $all = $request->all();
        if ($request->has('image_upload')) {
            $imageUrl = $request->file('image_upload')->store(PROJECT_IMAGE_FOLDER, 'uploads');
            $all['image_url'] = '/uploads/' . $imageUrl;
        }
        $user = Auth::user();
        $project = Project::find($id);
        if ($project && $user->can('edit', $project)) {
            $project->fill($all);
            $project->save();
            flash()->success(__l('project_edit_successully'));

            return redirect(route('project'));
        }
        abort(404);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $project = $this->service->detail($id);

        if ($project) {
            return view('end_user.project.detail', compact('project'));
        }
        abort(404);
    }

}
