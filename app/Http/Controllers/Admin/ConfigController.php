<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\AdditionalDate;
use App\Models\CalendarOff;
use App\Models\Config;
use App\Repositories\Contracts\IConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * ConfigController
 * Author: jvb
 * Date: 2018/11/15 16:31
 */
class ConfigController extends Controller
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.config';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::configs';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Config::class;

    /**
     * Controller construct
     */
    public function __construct(IConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $record = Config::firstOrNew([
            'id' => 1
        ]);
        $dayOffs = CalendarOff::all()->sortByDesc('id');
        $additionalDates = AdditionalDate::all()->sortByDesc('id');
        return view($this->resourceAlias . '._layout', [
            'resourceAlias' => $this->resourceAlias . '.index',
            'record' => $record,
            'dayOffs' => $dayOffs,
            'additionalDates' => $additionalDates,
        ]);
    }

    public function store(ConfigRequest $request)
    {
        $data = $request->all();

        if ($request->file('late_time_rule_file')) {
            $fileName = 'late_time-' . (date('Ymdhis')) . '.json';
            $path = LATE_MONEY_CONFIG_FOLDER;
            $request->file('late_time_rule_file')->storeAs($path, $fileName);

            $data['late_time_rule_json'] = $path . $fileName;
        }

        Config::updateOrCreate([
            'id' => 1
        ], $data);
        flash()->success(__l('config_updated'));
        return redirect(route($this->resourceRoutesAlias . '.index'));
    }

    public function dayoffCreate(Request $request)
    {
        $this->validate($request, [
            'date_name' => 'required|max:255',
            'date_off_from' => 'required|date',
            'date_off_to' => 'required|date|after_or_equal:date_off_from',
        ]);
        $data = $request->only('date_name', 'date_off_from', 'date_off_to', 'is_repeat');
        //check exists
        $check = CalendarOff::whereDate('date_off_from', '>=', $data['date_off_from'])->whereDate('date_off_to', '<=', $data['date_off_to'])->exists();
        if ($check) {
            $error = ValidationException::withMessages([
                'date_off_from' => ['Dữ liệu đã tồn tại'],
            ]);
            throw $error;
        }

        $calendarOff = new CalendarOff($data);
        $calendarOff->save();

        return response()->json($calendarOff);
    }

    public function dayoffDelete(Request $request)
    {
        CalendarOff::where('id', $request->id)->forceDelete();
    }

    public function additionalDateCreate(Request $request)
    {
        $this->validate($request, [
            'date_name' => 'required|max:255',
            'date_add' => 'required|date',
        ]);
        $data = $request->only('date_name', 'date_add');
        //check exists
        $check = AdditionalDate::whereDate('date_add', $data['date_add'])->exists();
        if ($check) {
            $error = ValidationException::withMessages([
                'date_off_from' => ['Dữ liệu đã tồn tại'],
            ]);
            throw $error;
        }

        $calendarOff = new AdditionalDate($data);
        $calendarOff->save();

        return response()->json($calendarOff);
    }

    public function additionalDateDelete(Request $request)
    {
        AdditionalDate::where('id', $request->id)->forceDelete();
    }
}
