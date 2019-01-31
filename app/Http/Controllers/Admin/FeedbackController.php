<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\User;
use App\Repositories\Contracts\IFeedbackRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * FeedbackController
 * Author: jvb
 * Date: 2019/01/30 02:59
 */
class FeedbackController extends AdminBaseController
{

	/**
	 * @var  string
	 */
	protected $resourceAlias = 'admin.feedbacks';

	/**
	 * @var  string
	 */
	protected $resourceRoutesAlias = 'admin::feedbacks';

	/**
	 * Fully qualified class name
	 *
	 * @var  string
	 */
	protected $resourceModel = Feedback::class;

	/**
	 * @var  string
	 */
	protected $resourceTitle = 'Feedback';

	/**
	 * Controller construct
	 * @param IFeedbackRepository $repository
	 */
	public function __construct(IFeedbackRepository $repository)
	{
		$this->repository = $repository;
		parent::__construct();
	}

	/**
	 * Validate the resource before perform updating in db
	 * @param $record Feedback new information in object type
	 * @return array rules to follow
	 */
	public function resourceUpdateValidationData($record)
	{
		return $this->validationData();
	}

	/**
	 * Validate request
	 * @return array rules request must follow
	 */
	private function validationData()
	{
		$questionRequest = new FeedbackRequest();
		return [
			'rules' => $questionRequest->rules(),
			'messages' => $questionRequest->messages(),
			'attributes' => $questionRequest->attributes(),
			'advanced' => [],
		];
	}

	/**
	 * validating the resource before storing to db
	 * @return array rules to follow
	 */
	public function resourceStoreValidationData()
	{
		return $this->validationData();
	}

	/**
	 * @param Request $request
	 * @param $values
	 * @return mixed
	 */
	public function alterValuesToSave(Request $request, $values)
	{
		if (empty($values['resolver_at']) && !empty($values['resolver_id'])) {
			$values['resolver_at'] = Carbon::now();
		}

		return $values;
	}

	public function filterShowViewData($record, $data = [])
	{
		return $this->makeRelationDataExisted($data);
	}

	/**
	 * Appending the original array of result with result found in DB
	 * @param array $data original data
	 * @return array appended array
	 */
	private function makeRelationDataExisted($data = [])
	{
		$user = new User();
		$data['request_user'] = $user->approverUsers()->where('id', $data['user_id'])->first();
		$data['resolve_user'] = $user->approverUsers()->where('id', $data['resolver_id'])->first();
		return $data;
	}

	public function filterEditViewData($record, $data = [])
	{
		return $this->makeRelationData($data);
	}

	/**
	 * Appending the data which is going to be display in create/edit view with the data in DB
	 * @param array $data original data
	 * @return array appended array
	 */
	private function makeRelationData($data = [])
	{
		$userModel = new User();
		$data['request_users'] = $userModel->availableUsers()->pluck('name', 'id')->toArray();
		$data['resolvable_users'] = $userModel->approverUsers()->pluck('name', 'id')->toArray();
		return $data;
	}
}
