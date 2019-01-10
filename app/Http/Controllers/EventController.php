<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IEventRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(IEventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request)
    {
        $criterias = $request->only('page', 'page_size', 'search');

        $criterias['status'] = ACTIVE_STATUS;
        $perPage = $criterias['page_size'] ?? DEFAULT_PAGE_SIZE;
        $search = $criterias['search'] ?? '';

        $events = $this->eventRepository->findBy($criterias, [
            'id',
            'name',
            'slug_name',
            'event_date',
            'introduction',
            'place',
            'created_at',
        ]);

        return view('end_user.event.index', compact('events', 'search', 'perPage'));
    }

    public function detail($id)
    {
        $event = $this->eventRepository->findOneBy([
            'id' => $id,
            'status' => ACTIVE_STATUS
        ]);

        if ($event) {
            $event->view_count++;
            $event->save();
            return view('end_user.event.detail', compact('event'));
        }
        abort(404);
    }
}
