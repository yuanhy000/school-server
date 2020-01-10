<?php

namespace App\Listeners\CreateTopic;

use App\Events\CreateTopic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserIssueIncrement
{

    public function handle(CreateTopic $event)
    {
        $user = auth()->guard('api')->user();
        $user->article_count += 1;
        $user->save();
    }
}
