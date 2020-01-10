<?php

namespace App\Listeners\CreateTopic;

use App\Article;
use App\Events\CreateArticle;
use App\Events\CreateTopic;
use App\Topic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetTopicTemperature
{
    public function handle(CreateTopic $event)
    {
        $this->setTemperature(Topic::find($event->topic_id));
    }

    public function setTemperature($topic)
    {
        $topic->temperature = Topic::getTopicTemperature($topic);
        $topic->save();
    }
}
