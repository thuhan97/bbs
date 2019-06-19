<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

/**
 * IPunishesService contract
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
interface IPunishesService extends IBaseService
{
    public function search(Request $request, $userId, &$perPage, &$search);

    public function detail($id);
}
