<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $team = $this->team();
        $group = $team->group() ?? null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'team' => $team,
            'group' => $group,
            'job_name' => JOB_TITLES[$this->jobtitle_id] ?? '',
        ];
    }
}
