<?php

namespace App\Listeners\CreateAnswer;

use App\Events\CreateAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserIssueIncrement
{

    public function handle(CreateAnswer $event)
    {
        $user = auth()->guard('api')->user();
        $user->article_count += 1;
        $user->save();
    }
}
