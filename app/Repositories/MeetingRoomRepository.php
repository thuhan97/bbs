<?php

namespace App\Repositories;

use App\Models\MeetingRoom;
use App\Repositories\Contracts\IMeetingRoomRepository;

/**
 * MeetingRoomRepository class
 * Author: jvb
 * Date: 2019/03/11 06:46
 */
class MeetingRoomRepository extends AbstractRepository implements IMeetingRoomRepository
{
    /**
     * DeviceModel
     *
     * @var  string
     */
    protected $modelName = MeetingRoom::class;
}
