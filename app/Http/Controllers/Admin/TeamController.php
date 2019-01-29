<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserTeam;
use App\Repositories\TeamRepository;
use App\Services\Contracts\ITeamService;
use App\Services\Contracts\IUserTeamService;
use App\Services\DetailTeamService;
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
        DetailTeamService $detailTeamService,
        TeamService $teamService
//        IUserTeamService $userTeamService
    )
    {
        $this->repository = $repository;
        $this->teamService = $teamService;
        $this->detailTeamService = $detailTeamService;
//        $this->userTeamService = $userTeamService;
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

    public function manageMember(){
        $team = new Team;
        $member_other = $team->getMemberNotInTeam();
//        dd($member_other);
        $data = array (
            'members_other'=>$member_other,
        );
//
        return view('admin.teams.user_team')->with($data);
    }


    public function show($id)
    {
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $record->leader_name = $this->teamService->getUsersAttribute($record->leader_id);
        $members = $this->teamService->getAllMember($id);
        return view($this->getResourceShowPath(), $this->filterShowViewData($record, [
            'record' => $record,
            'members' => $members,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
    }

    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());

        $perPage = (int)$request->input('per_page', '');
        $perPage = (is_numeric($perPage) && $perPage > 0 && $perPage <= 100) ? $perPage : DEFAULT_PAGE_SIZE;
        $search = $request->input('search', '');

        $records = $this->getSearchRecords($request, $perPage, $search);

        $records->appends($request->except('page'));
        foreach ($records as $record){
            $record->leader_name = $this->teamService->getUsersAttribute($record->leader_id);
        }
        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'records' => $records,
            'search' => $search,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
        ]));
    }

}
