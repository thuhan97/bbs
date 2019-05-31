<?php

namespace App\Http\Controllers\Admin;

use App\Events\SuggestionNotifyEvent;
use App\Models\Suggestion;
use App\Models\User;
use App\Repositories\Contracts\ISuggestionRepository;

/**
 * SuggestionController
 * Author: jvb
 * Date: 2019/05/31 10:33
 */
class SuggestionController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.suggestions';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::suggestions';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Suggestion::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Đề xuất - Góp ý';

    /**
     * Controller construct
     */
    public function __construct(ISuggestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'creator_id' => ['required', 'integer'],
                'content' => 'required',
                'status' => 'nullable|integer|between:0,1',
                'isseus_id' => 'nullable', 'integer',
            ],
            'messages' => [],
            'attributes' => [
                'creator_id' => 'người đề xuất',
                'content' => 'nội dung',
                'isseus_id' => 'người thực hiện',
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'creator_id' => ['nullable', 'integer'],
                'content' => 'required',
                'status' => 'nullable|integer|between:0,1',
                'isseus_id' => 'nullable', 'integer',
            ],
            'messages' => [],
            'attributes' => [
                'creator_id' => 'người đề xuất',
                'content' => 'nội dung',
                'isseus_id' => 'người thực hiện',
            ],
            'advanced' => [],
        ];
    }

    public function getRedirectAfterSave($record, $request, $isCreate = null)
    {
        if ($record->isseus_id) {
            $user=User::find($record->isseus_id);
            event(new SuggestionNotifyEvent($record,$user));
        }
        return redirect()->route($this->getResourceRoutesAlias() . '.index');
    }
}
