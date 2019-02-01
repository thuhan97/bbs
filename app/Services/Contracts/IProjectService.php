<?php 
namespace App\Services\Contracts;

/**
* IProjectService contract
* Author: jvb
* Date: 2019/01/31 05:00
*/
interface IProjectService extends IBaseService {
    public function detail($id);
}
