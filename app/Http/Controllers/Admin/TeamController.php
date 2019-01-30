<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserTeam;
use App\Repositories\TeamRepository;
use App\Services\Contracts\IUserTeamService;
use App\Services\TeamService;
use App\Traits\Controllers\ResourceController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\Contracts\ITeamRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use Illuminate\Support\Facades\DB;

class TeamController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.teams';
    protected $resourceAliasLeader = 'admin.teams_lead';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::teams';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Team::class;


    protected $resourceSearchExtend = 'admin.teams._partials.search_form';

    /**
     * @var  string
     */
    protected $resourceTitle = 'Nhóm';

    public function __construct(
        ITeamRepository $repository,
        TeamService $teamService
    )
    {
        $this->repository = $repository;
        $this->teamService = $teamService;
        parent::__construct();
    }
//
    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'leader_id' => 'required',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên nhóm',
                'leader_id' => 'trưởng nhóm',
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'leader_id' => 'required',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên nhóm',
                'leader_id' => 'trưởng nhóm',
            ],
            'advanced' => [],
        ];
    }

    public function manageMember($id){
        $team = new Team;
        $record = $this->repository->findOne($id);
        $member_not_in_team = $team->getMemberNotInTeam($record->leader_id);
        $data = array (
            'record' => $record
        );
        return view($this->getResourceManageMemberPath(), $this->filterShowViewData($record, [
            'record' => $record,
            'member_not_in_team' => $member_not_in_team,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
//
    }

    public function update(Request $request, $id)
    {
        $record = $this->repository->findOne($id);
        UserTeam::where('user_id',$record->leader_id)
                      ->where('team_id',$id)
                      ->delete();
        $this->authorize('update', $record);

        $valuesToSave = $this->getValuesToSave($request, $record);
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'update', $record);

        if ($this->repository->update($record, $this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success('Cập nhật thành công.');

            return $this->getRedirectAfterSave($record);
        } else {
            flash()->info('Cập nhật thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    public function saveUserTeam(Request $request){
        $record = $this->repository->findOne($request->id);
        UserTeam::where('team_id',$request->id)
            ->where('user_id','<>',$record->leader_id)
            ->delete();
        $users_id_add = $request->to;
        foreach ($users_id_add as $user_id){
            $user_team = new UserTeam;
            $user_team->team_id = $request->id;
            $user_team->user_id = $user_id;
            $user_team->save();
        }
        return redirect()->action('Admin\TeamController@manageMember', ['id' => $request->id]);
    }

}
