<?php
/**
 * EventService class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */

namespace App\Services;

use App\Models\Event;
use App\Repositories\Contracts\IEventRepository;
use App\Services\Contracts\IEventService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventService extends AbstractService implements IEventService
{
    /**
     * PostService constructor.
     *
     * @param \App\Models\Event $model
     * @param \App\Repositories\Contracts\IEventRepository $repository
     */
    public function __construct(Event $model, IEventRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search)
    {
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        return $this->repository->findBy($criterias, $this->list_fields());

    }

    /**
     * @param int $id
     *
     * @return Event
     */
    public function detail($id)
    {
        $event = $this->repository->findOneBy([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ]);

        if ($event) {
            $event->view_count++;
            $event->save();

            return $event;
        }
    }

    /**
     * @param Request $request
     *
     * @return collection
     */
    public function search_calendar(Request $request)
    {
        $timeRange = $request->only('start', 'end');
        $events = $this->model
            ->select($this->list_fields())
            ->where('status', ACTIVE_STATUS)
            ->where(function ($q) use ($timeRange) {
                $q->whereBetween('event_date', $timeRange)
                    ->orWhereBetween('event_end_date', $timeRange);
            })
            ->search($request->get('search'))
            ->get();

        return $events;
    }

    /**
     * @return array
     */
    private function list_fields()
    {
        return [
            'id',
            'name',
            'slug_name',
            'event_date',
            'event_end_date',
            'introduction',
            'place',
            'created_at',
        ];
    }
}
