<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeInformationResource extends JsonResource
{
    public $articles;
    public $activities;
    public $recruits;
    public $news;
    public $commodities;
    public $hasNews;
    public $topics;
    public $answers;

    public function __construct($resource, $articles, $activities, $recruits, $commodities, $news, $hasNews, $topics, $answers)
    {
        parent::__construct($resource);
        $this->articles = $articles;
        $this->activities = $activities;
        $this->recruits = $recruits;
        $this->commodities = $commodities;
        $this->news = $news;
        $this->hasNews = $hasNews;
        $this->topics = $topics;
        $this->answers = $answers;
    }

    public function toArray($request)
    {
        return [

            'commodities' => CommodityResource::collection($this->commodities),
            'articles' => ArticleResource::collection($this->articles),
            'activities' => ActivityResource::collection($this->activities),
            'recruits' => RecruitResource::collection($this->recruits),
            'topics' => TopicResource::collection($this->topics),
            'answers' => AnswerResource::collection($this->answers),
            'news' => $this->when($this->hasNews == -1, function () {
                return NewsResource::collection($this->news);
            }),
        ];
    }
}
