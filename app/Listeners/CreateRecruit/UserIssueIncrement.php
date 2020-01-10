<?php

namespace App\Listeners\CreateRecruit;

use App\Events\CreateReruit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserIssueIncrement
{
    public function handle(CreateReruit $event)
    {
        $user = auth()->guard('api')->user();
        $user->article_count += 1;
        $user->save();
    }
}
