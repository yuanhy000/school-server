<?php

namespace App\Http\Resources;

use App\CollectNews;
use App\LikeNews;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'news_id' => $this->id,
            'news_title' => $this->title,
            'news_content' => $this->content,
            'news_author' => $this->author,
            'news_likes' => $this->likes,
            'news_views' => $this->views,
            'news_created' => $this->created_at->format('Y-m-d'),
            'news_images' => ImageResource::collection($this->images),
            'news_comments_count' => $this->comments->count(),
            'news_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'news_like' => (boolean)$this->when(true, function () {
                return (boolean)LikeNews::isLikeNews($this->id, auth()->guard('api')->user()->id);
            }),
            'news_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectNews::isCollectNews($this->id, auth()->guard('api')->user()->id);
            }),
        ];
    }
}
