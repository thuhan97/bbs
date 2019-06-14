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
        $users = User::select('id', DB::raw('CONCAT(staff_code, " - ", name) as name'))->where('status', ACTIVE_STATUS)->orderBy('jobtitle_id', 'desc')->orderBy('staff_code')->pluck('name', 'id')->toArray();
        $results['Danh sách nhân viên'] = $users;
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
        $this->saveProjectMember($project,$request,true,null);
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
                $checkUserIds=[];
                foreach ($project->projectMembers as $pro){
                    $checkUserIds[]=$pro->user_id;
                    $pro->delete();
                }
                $this->saveProjectMember($project,$request,false,$checkUserIds);
                foreach ($checkUserIds as $checkUserId){
                    if (!in_array($checkUserId,$request->user_id)){
                        broadcast(new ProjectNotify($project,$checkUserId,true))->toOthers();
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
    public function checkNameUnique($id=DEFAULT_VALUE,$name){
       $nameProject=Project::where('name',$name)->first()->name ?? null;
        if ($id){
          $project=Project::find($id);
          if ($project->name == $nameProject){
              return response(['success' => false]);  
          }
        }
       if ($nameProject) {
           return response(['success' => true]);
       }else{
             return response(['success' => false]);
       }

    }

    private function saveProjectMember($project,$request,$isCreate=false,$checkUserId=null){
        if ($request->user_id){
            foreach ($request->user_id as $key => $userID){
                $projectMember=new ProjectMember();
                $projectMember->project_id=$project->id;
                $projectMember->user_id=$userID;
                $projectMember->mission=$request->mission[$key] ?? null;
                $projectMember->contract=$request->contract[$key] ?? null;
                $projectMember->reality=$request->reality[$key] ?? null;
                $projectMember->time_start=$request->time_start[$key] ?? null;
                $projectMember->time_end=$request->time_end[$key] ?? null;
                $projectMember->save();
                if ($isCreate){
                    if ($project->leader_id != $userID){
                        broadcast(new ProjectNotify($project,$userID))->toOthers();
                    }
                }else{
                    if ($project->leader_id != $userID  && !in_array($userID,$checkUserId)){
                        broadcast(new ProjectNotify($project,$userID))->toOthers();
                    }
                }

            }
        }
    }

}
