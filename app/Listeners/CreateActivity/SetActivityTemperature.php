<?php

namespace App\Listeners\CreateActivity;

use App\Activity;
use App\Commodity;
use App\Events\CreateActivity;
use App\Events\CreateCommodity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetActivityTemperature
{

    public function handle(CreateActivity $event)
    {
        $this->setTemperature(Activity::find($event->activity_id));
    }

    public function setTemperature($activity)
    {
        $activity->temperature = Activity::getActivityTemperature($activity);
        $activity->save();
    }
}
