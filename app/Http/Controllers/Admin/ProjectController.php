<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/31/2019
 * Time: 3:15 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\Project;
use App\Repositories\Contracts\ITeamRepository;
use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
    use App\Repositories\Contracts\IProjectRepository;
use App\Repositories\Contracts\IUserRepository;
class ProjectController extends AdminBaseController
{
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


//    protected $resourceSearchExtend = 'admin.projects._search_extend';

    /**
     * @var  string
     */


    protected $resourceTitle = 'Dự án';

    public function __construct(
        IProjectRepository $repository
    )
    {
        $this->repository = $repository;
        parent::__construct();
    }
//
    public function resourceStoreValidationData()
    {
//        return [
//            'rules' => [
//                'name' => 'required|max:255',
//                'leader_id' => 'required',
//            ],
//            'messages' => [],
//            'attributes' => [
//                'name' => 'tên nhóm',
//                'leader_id' => 'trưởng nhóm',
//            ],
//            'advanced' => [],
//        ];
    }

    public function resourceUpdateValidationData($record)
    {
//        return [
//            'rules' => [
//                'name' => 'required|max:255',
//                'leader_id' => 'required',
//            ],
//            'messages' => [],
//            'attributes' => [
//                'name' => 'tên nhóm',
//                'leader_id' => 'trưởng nhóm',
//            ],
//            'advanced' => [],
//        ];
    }





}