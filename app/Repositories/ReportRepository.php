<?php 
namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Contracts\IReportRepository;

/**
* ReportRepository class
* Author: trinhnv
* Date: 2019/01/21 03:42
*/
class ReportRepository extends AbstractRepository implements IReportRepository
{
     /**
     * ReportModel
     *
     * @var  string
     */
	  protected $modelName = Report::class;
}
