<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\UserTeam;
use App\Repositories\Contracts\ITeamRepository;
use App\Services\TeamService;
use Illuminate\Http\Request;

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


//    protected $resourceSearchExtend = 'admin.teams._search_extend';

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

    public function getResourceManageMemberPath()
    {
        return 'admin.teams.user_team';
    }

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

    public function manageMember($id)
    {
        $team = new Team;
        $record = $this->repository->findOne($id);
        $member_not_in_team = $team->getMemberNotInTeam();

        return view($this->getResourceManageMemberPath(), $this->filterShowViewData($record, [
            'record' => $record,
            'member_not_in_team' => $member_not_in_team,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
//
    }

    public function updateTmp(Request $request, $id)
    {
        $record = $this->repository->findOne($id);
        UserTeam::where('user_id', $record->leader_id)
            ->where('team_id', $id)
            ->delete();
        return $this->update($request, $id);
    }

    public function saveUserTeam(Request $request)
    {
        $this->validate($request, [
            'member_ids' => 'array'
        ]);
        $record = $this->repository->findOne($request->id);
        if ($record) {
            UserTeam::where('team_id', $record->id)
                ->delete();

            $member_ids = $request->member_ids;
            if ($member_ids) {
                $userTeams = [];
                foreach ($member_ids as $member_id) {
                    if ($record->leader_id != $member_id)
                        $userTeams[] = [
                            'team_id' => $record->id,
                            'user_id' => $member_id,
                        ];
                }
                UserTeam::insertAll($userTeams);
            }
            return redirect()->action('Admin\TeamController@manageMember', ['id' => $request->id]);
        }
        abort(404);
    }

    public function getRedirectAfterSave($record, $request, $isCreate = null)
    {
        return redirect()->route($this->getResourceRoutesAlias() . '.index');
    }

}
