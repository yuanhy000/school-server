<?php

namespace App\Http\Resources;

use App\Activity;
use App\Article;
use App\Commodity;
use App\Notification;
use App\Recruit;
use App\UserFollow;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $count;
    public $other;

    public function __construct($resource, $count = 0, $other = 0)
    {
        parent::__construct($resource);
        $this->count = $count;
        $this->other = $other;
    }

    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'user_number' => $this->number,
            'user_name' => $this->name,
            'user_avatar' => $this->avatar,
            'user_school' => $this->school,
            'user_organization' => $this->organization,
            'user_sex' => $this->sex,
            'user_attentions' => $this->attentions,
            'user_followers' => $this->followers,
            'user_article_count' => $this->article_count,
            'user_created' => $this->created_at,
            'user_notice_count' => $this->when($this->count == -1, function () {
                return Notification::where([
                    ['accept_user_id', '=', $this->id],
                    ['status', '=', 0]
                ])->count();
            }),
            'user_follow' => (boolean)$this->when(true, function () {
                return (boolean)UserFollow::isFollowUser($this->id, auth()->guard('api')->user()->id);
            }),
            'user_articles' => $this->when($this->other == -1, function () {
                return ArticleResource::collection(Article::where('user_id', $this->id)
                    ->orderBy('created_at', 'desc')->paginate(1));
            }),
            'user_recruits' => $this->when($this->other == -1, function () {
                return RecruitResource::collection(Recruit::where('user_id', $this->id)
                    ->orderBy('created_at', 'desc')->paginate(1));
            }),
            'user_activities' => $this->when($this->other == -1, function () {
                return ActivityResource::collection(Activity::where('user_id', $this->id)
                    ->orderBy('created_at', 'desc')->paginate(1));
            }),
//            'user_commodities' => $this->when($this->other == -1, function () {
//                return CommodityResource::collection(Commodity::where('user_id', $this->id)
//                    ->orderBy('created_at', 'desc')->paginate(1));
//            }),
        ];
    }
}

