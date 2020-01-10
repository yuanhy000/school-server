<?php

namespace App\Listeners\CreateActivity;

use App\Events\CreateActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserIssueIncrement
{

    public function handle(CreateActivity $event)
    {
        $user = auth()->guard('api')->user();
        $user->article_count += 1;
        $user->save();
    }
}
