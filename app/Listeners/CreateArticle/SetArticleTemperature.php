<?php

namespace App\Listeners\CreateArticle;

use App\Article;
use App\Commodity;
use App\Events\CreateArticle;
use App\Events\CreateCommodity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetArticleTemperature
{

    public function handle(CreateArticle $event)
    {
        $this->setTemperature(Article::find($event->article_id));
    }

    public function setTemperature($article)
    {
        $article->temperature = Article::getArticleTemperature($article);
        $article->save();
    }
}
