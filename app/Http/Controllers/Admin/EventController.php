<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Repositories\Contracts\IEventRepository;

/**
 * EventController
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class EventController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.events';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::events';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Event::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Sự kiện';

    /**
     * Controller construct
     */
    public function __construct(IEventRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData();
    }

    private function validationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'image_url' => 'required|max:1000',
                'introduction' => 'required|max:500',
                'content' => 'required',
                'status' => 'required|numeric',
                'event_date' => 'required|date',
                'event_end_date' => 'date|after_or_equal:event_date',

            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

}
