<?php

namespace App\Listeners\createrecruit;

use App\Article;
use App\Events\CreateArticle;
use App\Events\CreateReruit;
use App\Recruit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetRecruitTemperature
{
    public function handle(CreateReruit $event)
    {
        $this->setTemperature(Recruit::find($event->recruit_id));
    }

    public function setTemperature($recruit)
    {
        $recruit->temperature = Recruit::getRecruitTemperature($recruit);
        $recruit->save();
    }
}
