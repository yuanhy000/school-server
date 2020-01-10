<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;

class InformationResource extends JsonResource
{
    public $articles;
    public $activities;
    public $recruits;
    public $attentions;
    public $news;

    public function __construct($resource, $articles, $activities, $recruits, $attentions, $news)
    {
        parent::__construct($resource);
        $this->articles = $articles;
        $this->activities = $activities;
        $this->recruits = $recruits;
        $this->attentions = $attentions;
        $this->news = $news;
    }

    public function toArray($request)
    {
        return [
            'news' => new NewsCollection($this->news),
            'attentions' => new ArticleCollection($this->attentions),
            'articles' => new ArticleCollection($this->articles),
            'activities' => new ActivityCollection($this->activities),
            'recruits' => new RecruitCollection($this->recruits),
        ];
    }
}
