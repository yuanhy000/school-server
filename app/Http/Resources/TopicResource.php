<?php

namespace App\Http\Resources;

use App\CollectTopic;
use App\LikeTopic;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{

    public $is_detail;

    public function __construct($resource, $is_detail)
    {
        parent::__construct($resource);
        $this->is_detail = $is_detail;
    }


    public function toArray($request)
    {
        return ['topic_id' => $this->id,
            'topic_title' => $this->title,
            'topic_content' => $this->content,
            'topic_likes' => $this->likes,
            'topic_views' => $this->views,
            'topic_location' => $this->location,
            'topic_anonymity' => $this->anonymity,
            'topic_display_location' => $this->display_location,
            'topic_created' => $this->created_at->format('Y-m-d H:i'),
            'topic_user' => new UserResource($this->user),
            'topic_images' => ImageResource::collection($this->images),
            'topic_answer_count' => $this->answer_count,
            'topic_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeTopic::isLikeTopic($this->id, auth()->guard('api')->user()->id);
            }),
            'topic_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectTopic::isCollectTopic($this->id, auth()->guard('api')->user()->id);
            }),
//            'topic_answer' => (boolean)$this->when($this->is_detail == -1, function () {
//                return (boolean)CollectTopic::isCollectTopic($this->id, auth()->guard('api')->user()->id);
//            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),];
    }
}
