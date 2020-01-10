<?php

namespace App\Http\Resources;

use App\CollectAnswer;
use App\LikeAnswer;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'answer_id' => $this->id,
            'answer_title' => $this->title,
            'answer_content' => $this->content,
            'answer_likes' => $this->likes,
            'answer_views' => $this->views,
            'answer_anonymity' => $this->anonymity,
            'answer_display_location' => $this->display_location,
            'answer_created' => $this->created_at->format('Y-m-d H:i'),
            'answer_user' => new UserResource($this->user),
            'answer_images' => ImageResource::collection($this->images),
            'answer_comments_count' => $this->comments->count(),
            'answer_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'answer_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeAnswer::isLikeAnswer($this->id, auth()->guard('api')->user()->id);
            }),
            'answer_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectAnswer::isCollectAnswer($this->id, auth()->guard('api')->user()->id);
            }),
            'answer_topic' => $this->when(true, function () {
                return new TopicResource($this->topic, 0);
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),];
    }
}
