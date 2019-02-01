<?php

namespace App\Services\Contracts;

use App\Models\DayOff;
use Illuminate\Http\Request;

/**
 * IDayOffService contract
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
interface IDayOffService extends IBaseService
{
	/**
	 * @param Request $request
	 * @param array $moreConditions
	 * @param array $fields
	 * @param string $search
	 * @param int $perPage
	 *
	 * @return mixed
	 */
	public function findList(Request $request, $moreConditions = [], $fields = ['*'], &$search = '', &$perPage = DEFAULT_PAGE_SIZE);

	/**
	 * @param $userId
	 *
	 * @return array
	 */
	public function getDayOffUser($userId);

	/**
	 * Update the status (from not approved to approved) of a user)
	 * @param $recordID int record's id
	 * @param $approvalID int approval's id
	 * @param $comment string approval's comment on the absence request
	 * @param int $approve default as approved
	 * @param float $number_off
	 * @return boolean Indicate whether the action is performed or not
	 */
	public function updateStatusDayOff($recordID, $approvalID, $comment, $approve = DayOff::APPROVED_STATUS, $number_off = 0.5);

	/**
	 * find a record of day off by ID.
	 * @param $recordID int|string id of the day off record
	 * @return mixed day off record
	 */
	public function getRecordOf($recordID);

	/**
	 * @param $user_id  string|integer  User owning the absence
	 * @param $title    string  title of the absence record
	 * @param $reason   string  detail reason of the absence record
	 * @param $start_at string  day start of the absence record
	 * @param $end_at   string  day end of the absence record
	 * @param $approvalID string id of approval
	 * @return mixed array contain the "status" indicate the successful of the action and the "record" which will be the record saved
	 */
	public function create($user_id, $title, $reason, $start_at, $end_at, $approvalID);

	/**
	 * @return mixed Collection contain all the approval
	 */
	public function listApprovals();
}
