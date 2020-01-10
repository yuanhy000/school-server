<?php

namespace App\Http\Resources;

use App\CollectRecruit;
use App\LikeRecruit;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitResource extends JsonResource
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
            'recruit_id' => $this->id,
            'recruit_title' => $this->title,
            'recruit_content' => $this->content,
            'recruit_target' => $this->target,
            'recruit_likes' => $this->likes,
            'recruit_views' => $this->views,
            'recruit_location' => $this->location,
            'recruit_display_location' => $this->display_location,
            'recruit_created' => $this->created_at->format('Y-m-d H:i'),
            'recruit_user' => new UserResource($this->user),
            'recruit_images' => ImageResource::collection($this->images),
            'recruit_comments_count' => $this->comments->count(),
            'recruit_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'recruit_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeRecruit::isLikeRecruit($this->id, auth()->guard('api')->user()->id);
            }),
            'recruit_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectRecruit::isCollectRecruit($this->id, auth()->guard('api')->user()->id);
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),
        ];
    }
}
