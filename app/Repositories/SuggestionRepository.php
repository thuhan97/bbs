<?php 
namespace App\Repositories;

use App\Models\Suggestion;
use App\Repositories\Contracts\ISuggestionRepository;

/**
* SuggestionRepository class
* Author: jvb
* Date: 2019/05/31 10:33
*/
class SuggestionRepository extends AbstractRepository implements ISuggestionRepository
{
/**
* SuggestionModel
*
* @var  string
*/
protected $modelName = Suggestion::class;
}
