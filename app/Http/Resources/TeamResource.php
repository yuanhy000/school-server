<?php

namespace App\Http\Resources;

use App\Activity;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'team_id' => $this->id,
            'team_name' => $this->name,
            'team_created' => $this->created_at,
            'team_manager' => new UserResource(User::find($this->manager_id)),
            'team_member' => UserResource::collection($this->users),
            'team_activity' => new ActivityResource(Activity::find($this->activity_id), 0),
        ];
    }
}
