<?php 
namespace App\Repositories;

use App\Models\Feedback;
use App\Repositories\Contracts\IFeedbackRepository;

/**
* FeedbackRepository class
* Author: jvb
* Date: 2019/01/30 02:59
*/
class FeedbackRepository extends AbstractRepository implements IFeedbackRepository
{
     /**
     * FeedbackModel
     *
     * @var  string
     */
	  protected $modelName = Feedback::class;
}
