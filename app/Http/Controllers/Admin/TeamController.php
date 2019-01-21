<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\IUserRepository;
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

}
