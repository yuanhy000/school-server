<?php

namespace App\Http\Resources;

use App\CollectActivity;
use App\LikeActivity;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public $is_detail;

    public function __construct($resource, $is_detail)
    {
        parent::__construct($resource);
        $this->is_detail = $is_detail;
    }

    public function toArray($request)
    {
        return [
            'activity_id' => $this->id,
            'activity_name' => $this->name,
            'activity_content' => $this->content,
            'activity_attention' => $this->attention,
            'activity_likes' => $this->likes,
            'activity_views' => $this->views,
            'activity_school' => $this->school,
            'activity_created' => $this->created_at->format('Y-m-d H:i'),
            'activity_organization' => $this->organization,
            'activity_user' => new UserResource($this->user),
            'activity_images' => ImageResource::collection($this->images),
            'activity_comments_count' => $this->comments->count(),
            'activity_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'activity_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeActivity::isLikeActivity($this->id, auth()->guard('api')->user()->id);
            }),
            'activity_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectActivity::isCollectActivity($this->id, auth()->guard('api')->user()->id);
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),
        ];
    }
}
