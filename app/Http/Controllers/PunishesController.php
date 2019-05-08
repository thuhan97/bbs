<?php

namespace App\Http\Controllers;

use App\Models\Punishes;
use App\Repositories\Contracts\IPunishesRepository;
use App\Traits\RESTActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PunishesController extends Controller
{
    use RESTActions;

    private $reportRepository;

    public function __construct(IPunishesRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->has('year'))
            $request->merge(['year' => date('Y')]);
        if (!$request->has('month'))
            $request->merge(['month' => date('n')]);
        $perPage = $this->getPageSize($request);
        $punishes = Punishes::where('user_id', Auth::id())
            ->whereYear('infringe_date', $request->year)
            ->whereMonth('infringe_date', $request->month)
//            ->whereHas('rule')
            ->orderBy('id', 'desc')
            ->get();

        return view('end_user.punish.index', compact('punishes', 'perPage'));
    }

}
