<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IMeetingRepository;
use App\Services\Contracts\IMeetingService;

class MeetingController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.meetings';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::meetings';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Meeting::class;

    protected $meetingService;

//    protected $resourceSearchExtend = 'admin.teams._search_extend';

    /**
     * @var  string
     */
    protected $resourceTitle = 'Phòng họp';

    public function __construct(IMeetingRepository $repository, IMeetingService $meetingService)
    {
        $this->repository = $repository;
        $this->meetingService = $meetingService;
        parent::__construct();
    }
    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255|unique:meetings',
                'seats'=> 'numberic'
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên phòng',
                'seats'=> 'số ghế'
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255|unique:meetings,id,'.$record->name,
                'seats'=> 'numberic'
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên phòng',
                'seats'=> 'số ghế',
            ],
            'advanced' => [],
        ];
    }

   

}
