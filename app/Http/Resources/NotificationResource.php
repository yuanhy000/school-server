<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'notification_id' => $this->id,
            'notification_content' => $this->content,
            'request_user' => new UserResource(User::find($this->request_user_id)),
            'notification_created' => $this->created_at->format('Y-m-d H:i'),
            'notification_status' => $this->status,
            'notification_operation' => $this->operation,
            'notification_type' => $this->type,
            'notification_target_id' => $this->target_id
        ];
    }
}
