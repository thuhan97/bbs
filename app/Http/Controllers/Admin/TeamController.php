<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserTeam;
use App\Traits\Controllers\ResourceController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\Contracts\ITeamRepository;

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

    public function __construct(ITeamRepository $repository)
    {
        $this->repository = $repository;
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

}
