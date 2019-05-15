<?php

namespace App\Exports;

use App\Models\Punishes;
use App\User;
use Illuminate\Http\Request;

abstract class WTGridExport
{
    protected $records;
    protected $firstDate;
    protected $lastDate;
    /**
     * @var array
     */
    protected $dateLists;

    protected $headings;
    protected $importList;
    protected $punishes;

    /**
     * WorkTimeGridExport constructor.
     *
     * @param $records
     */
    public function __construct($records, Request $request, $isGetPunishe = false)
    {
        $userModel = User::select('id', 'staff_code', 'name')
            ->where('status', ACTIVE_STATUS);
        $userID = $request->get('user_id', 0);
        if ($userID) {
            $this->users = $userModel
                ->where('id', $userID)
                ->get();
        } else {
            $this->users = $userModel
                ->orderBy('contract_type')
                ->orderBy('id')
                ->get();
        }

        $this->records = $records;
        [$firtDate, $lastDate] = getStartAndEndDateOfMonth($request->get('month'), $request->get('year'));
        $this->firstDate = $firtDate;
        $this->lastDate = $lastDate;
        $this->dateLists = get_date_list($this->firstDate, $this->lastDate);

        if ($isGetPunishe)
            $this->punishes = Punishes::where('infringe_date', '>=', $this->firstDate)
                ->where('infringe_date', '<=', $this->lastDate)
                ->where('rule_id', LATE_RULE_ID)
                ->get();

        $this->getHeadings();
        $this->getList();
    }

    protected function getHeadings(): void
    {
    }

    protected function getList(): void
    {
    }

}
