<?php 
namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Contracts\IAdminRepository;

/**
* AdminRepository class
* Author: jvb
* Date: 2018/09/03 01:52
*/
class AdminRepository extends AbstractRepository implements IAdminRepository
{
     /**
     * AdminModel
     *
     * @var  string
     */
	  protected $modelName = Admin::class;
}
