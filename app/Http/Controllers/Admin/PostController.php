<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;

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
                'status' => 'required|numeric',
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
                'status' => 'required|numeric',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

}
