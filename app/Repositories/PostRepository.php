<?php 
namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;

/**
* PostRepository class
* Author: trinhnv
* Date: 2018/11/11 13:59
*/
class PostRepository extends AbstractRepository implements IPostRepository
{
     /**
     * PostModel
     *
     * @var  string
     */
	  protected $modelName = Post::class;
}
