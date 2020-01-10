<?php

namespace App\Listeners\CreateCommodity;

use App\Commodity;
use App\Events\CreateCommodity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetCommodityTemperature
{

    public function handle(CreateCommodity $event)
    {
        $this->setTemperature(Commodity::find($event->commodity_id));
    }

    public function setTemperature($commodity)
    {
        $commodity->temperature = Commodity::getCommodityTemperature($commodity);
        $commodity->save();
    }
}
