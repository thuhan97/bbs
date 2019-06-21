<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Requests\SendBroadcastRequest;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Contracts\IPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * PostController
 * Author: jvb
 * Date: 2018/11/11 13:59
 */
class PostController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.posts';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::posts';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Post::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Thông báo';

    /**
     * Controller construct
     *
     * @param \App\Repositories\Contracts\IPostRepository $repository
     */
    public function __construct(IPostRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'author_name' => 'required|max:255',
                'image_url' => 'required|max:1000',
                'introduction' => 'required|max:1000',
                'content' => 'required',
                'status' => 'nullable|numeric',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'author_name' => 'required|max:255',
                'image_url' => 'required|max:1000',
                'introduction' => 'required|max:1000',
                'content' => 'required',
                'status' => 'nullable|numeric',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function getValuesToSave(Request $request, $record = null)
    {
        $data = $request->only($this->getResourceModel()::getFillableFields());
        if (!isset($data['status'])) {
            $data['status'] = UNACTIVE_STATUS;
        }

        return $data;
    }

    public function broadcast()
    {
        $users = $this->getUsers();

        return view('admin.posts.broadcast', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'users' => ['' => 'Tất cả nhân viên'] + $users,
        ]);
    }

    public function sendBroadcast(SendBroadcastRequest $request)
    {
        $userIds = $request->get('users_id');
        $title = $request->get('title');
        $content = $request->get('content');
        $url = $request->get('url', url());

        $userModel = User::select('id', 'name', 'last_activity_at')
            ->where('status', ACTIVE_STATUS)
            ->has('firebase_tokens')
            ->with('firebase_tokens');
        //
        if (empty($userIds) || $userIds[0] == null) {
            //nothing
        } else {
            $userModel = $userModel->whereIn('id', $userIds);
        }
        $users = $userModel->get();

        foreach ($users as $user) {
            $devices = [];
            foreach ($user->firebase_tokens as $firebase_token) {
                $devices[] = $firebase_token->token;
            }
            if (!empty($devices)) {
                NotificationHelper::sendPushNotification($devices, $title, $content, $url);
            }
        }
        flash()->success('Gửi thông báo thành công!');
        return redirect(route('admin::posts.broadcast'));
    }

    private function getUsers()
    {
        $userModel = new User();
        return $userModel->availableUsers()->select(DB::raw("CONCAT(staff_code, ' - ', name) as name"), 'id')->pluck('name', 'id')->toArray();
    }
}
