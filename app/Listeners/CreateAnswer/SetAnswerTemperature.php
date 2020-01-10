<?php

namespace App\Listeners\CreateAnswer;

use App\Answer;
use App\Events\CreateAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetAnswerTemperature
{
    public function handle(CreateAnswer $event)
    {
        $this->setTemperature(Answer::find($event->answer_id));
    }

    public function setTemperature($answer)
    {
        $answer->temperature = Answer::getAnswerTemperature($answer);
        $answer->save();
    }
}
