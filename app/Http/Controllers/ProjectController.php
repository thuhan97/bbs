<?php

namespace App\Http\Controllers;

use App\Events\ProjectNotify;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Services\Contracts\IProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('end_user.project.index', compact('projects', 'search', 'perPage','results'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::select('id', DB::raw('CONCAT(staff_code, " - ", name) as name'))->where('status', ACTIVE_STATUS)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name', 'id')->toArray();
        $results['Danh sách nhân viên'] = $users;
        $record = new Project();
        return view('end_user.project.create', compact('record','results'));
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
        if ($request->user_id){
            for ($i=0 ; $i < count($request->user_id) ; $i++){
                $projectMember=new ProjectMember();
                $projectMember->project_id=$project->id;
                $projectMember->user_id=$request->user_id[$i];
                $projectMember->mission=$request->mission[$i];
                $projectMember->contract=$request->contract[$i] ?? null;
                $projectMember->reality=$request->reality[$i] ?? null;
                $projectMember->time_start=$request->time_start[$i] ?? null;
                $projectMember->time_end=$request->time_end[$i] ?? null;
                $projectMember->save();
                if ($project->leader_id != $request->user_id[$i]){
                    broadcast(new ProjectNotify($project,$request->user_id[$i]))->toOthers();

                }
            }
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
            $users = User::select('id', DB::raw('CONCAT(staff_code, " - ", name) as name'))->where('status', ACTIVE_STATUS)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name', 'id')->toArray();
        $results['Danh sách nhân viên'] = $users;
            return view('end_user.project.update', compact('record','results'));

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
            \DB::beginTransaction();
            try {
                $check=[];
                foreach ($project->projectMembers as $pro){
                    $checks[]=$pro->user_id;
                    $pro->delete();
                }
                if ($request->user_id){
                    for ($i=0 ; $i < count($request->user_id) ; $i++){
                        $projectMember=new ProjectMember();
                        $projectMember->project_id=$project->id;
                        $projectMember->user_id=$request->user_id[$i];
                        $projectMember->mission=$request->mission[$i];
                        $projectMember->contract=$request->contract[$i] ?? null;
                        $projectMember->reality=$request->reality[$i] ?? null;
                        $projectMember->time_start=$request->time_start[$i] ?? null;
                        $projectMember->time_end=$request->time_end[$i] ?? null;
                        $projectMember->save();
                        if ($project->leader_id != $request->user_id[$i]  && !in_array($request->user_id[$i],$checks)){
                            broadcast(new ProjectNotify($project,$request->user_id[$i]))->toOthers();
                        }
                    }
                }
                foreach ($checks as $check){
                    if (!in_array($check,$request->user_id)){
                        broadcast(new ProjectNotify($project,$check,true))->toOthers();
                    }
                }
            } catch (Exception $ex) {
                \DB::rollback();
            }
            $project->fill($all);
            $project->save();
            \DB::commit();

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
