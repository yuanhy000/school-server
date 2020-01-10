<?php

namespace App\Listeners\CreateAnswer;

use App\Events\CreateAnswer;
use App\Topic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TopicAnswerCountIncrement
{

    public function handle(CreateAnswer $event)
    {
        $topic = Topic::find($event->topic_id);
        $topic->answer_count += 1;
        $topic->save();
    }
}
