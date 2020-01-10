<?php

namespace App\Listeners\CreateArticle;

use App\Events\CreateArticle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserIssueIncrement
{

    public function handle(CreateArticle $event)
    {
        $user = auth()->guard('api')->user();
        $user->article_count += 1;
        $user->save();
    }
}
