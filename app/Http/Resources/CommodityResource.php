<?php

namespace App\Http\Resources;

use App\CollectCommodity;
use App\Comment;
use App\Http\Controllers\CommodityController;
use App\LikeCommodity;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class CommodityResource extends JsonResource
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
            'commodity_id' => $this->id,
            'commodity_name' => $this->name,
            'commodity_description' => $this->description,
            'commodity_price' => $this->price,
            'commodity_likes' => $this->likes,
            'commodity_views' => $this->views,
            'commodity_location' => $this->location,
            'commodity_images' => ImageResource::collection($this->images),
            'commodity_user' => new UserResource($this->user),
            'commodity_comments' => $this->when($this->is_detail == -1, function () {
                return CommentResource::collection($this->comments->sortByDesc('created_at'));
            }),
            'commodity_like' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)LikeCommodity::isLikeCommodity($this->id, auth()->guard('api')->user()->id);
            }),
            'commodity_collect' => (boolean)$this->when($this->is_detail == -1, function () {
                return (boolean)CollectCommodity::isCollectCommodity($this->id, auth()->guard('api')->user()->id);
            }),
            'commodity_recommend' => $this->when($this->is_detail == -1, function () {
                return CommodityController::getSimilarRecommendCommodity($this->id, $this->category_id);
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->user->id, auth()->guard('api')->user()->id);
            }),
        ];
    }
}
