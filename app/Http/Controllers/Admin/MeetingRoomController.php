<?php

namespace App\Http\Controllers\Admin;

use App\Models\MeetingRoom;
use App\Repositories\Contracts\IMeetingRoomRepository;
use App\Services\Contracts\IMeetingRoomService;

class MeetingRoomController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.meeting_rooms';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::meeting_rooms';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = MeetingRoom::class;

    protected $meetingService;

//    protected $resourceSearchExtend = 'admin.teams._search_extend';

    /**
     * @var  string
     */
    protected $resourceTitle = 'Phòng họp';

    public function __construct(IMeetingRoomRepository $repository, IMeetingRoomService $meetingService)
    {
        $this->repository = $repository;
        $this->meetingService = $meetingService;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255|unique:meeting_rooms,name,NULL,id,deleted_at,NULL',
                'seats' => 'numeric',
                'description' => 'required',
                'color' => 'required|max:20',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên phòng',
                'seats' => 'số ghế',
                'color' => 'màu trên lịch',
                'description' => 'mô tả'
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255|unique:meeting_rooms,name,' . $record->id . ',id,deleted_at,NULL',
                'seats' => 'numeric',
                'description' => 'required',
                'color' => 'required|max:20',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên phòng',
                'seats' => 'số ghế',
                'color' => 'màu trên lịch',
                'description' => 'mô tả'

            ],
            'advanced' => [],
        ];
    }


}
