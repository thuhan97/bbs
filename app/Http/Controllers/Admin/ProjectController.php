<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/31/2019
 * Time: 3:15 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Repositories\Contracts\IProjectRepository;
use File;

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
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData($record);
    }

    public function validationData($record = null)
    {
        return [
            'rules' => [
                'name' => 'required|max:255|unique:users,email' . ($record ? (',' . $record->id) : ''),
                'customer' => 'required|max:255',
                'scale' => 'nullable|numeric|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên dự án',
                'customer' => 'khách hàng',
                'start_date' => 'ngày bắt đầu',
                'end_date' => 'ngày kết thúc',
                'scale' => 'quy mô dự án',
            ],
            'advanced' => [],
        ];
    }
}