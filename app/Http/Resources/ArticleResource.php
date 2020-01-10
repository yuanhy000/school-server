<?php

namespace App\Http\Resources;

use App\CollectArticle;
use App\LikeArticle;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'article_id' => $this->id,
            'article_title' => $this->title,
            'article_content' => $this->content,
            'article_likes' => $this->likes,
            'article_views' => $this->views,
            'article_location' => $this->location,
            'article_anonymity' => $this->anonymity,
            'article_display_location' => $this->display_location,
            'article_created' => $this->created_at->format('Y-m-d H:i'),
            'article_user' => new UserResource($this->user),
            'article_images' => ImageResource::collection($this->images),
            'article_comments_count' => $this->comments->count(),
            'article_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'article_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeArticle::isLikeArticle($this->id, auth()->guard('api')->user()->id);
            }),
            'article_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectArticle::isCollectArticle($this->id, auth()->guard('api')->user()->id);
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),
        ];
    }
}
