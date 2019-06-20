<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

/**
 * UserTransformer class
 * Author: jvb
 * Date: 2018/07/16 10:34
 */
class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $item)
    {
        $data = $item->toArray();
        $team = $item->team();
        $data['team_name'] = $team->name ?? '';
        $data['group_name'] = $team->group->name ?? '';
        $data['job_name'] = JOB_TITLES[$item->jobtitle_id] ?? '';
        return $data;
    }
}
