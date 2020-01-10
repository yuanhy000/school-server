<?php

namespace App\Console;

use App\Activity;
use App\Article;
use App\Commodity;
use App\News;
use App\Recruit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('inspire')
//            ->hourly();
        $schedule->call(function () {
            Log::info('更新热度');
            Commodity::updateCommodityTemperature();
            Article::updateArticleTemperature();
            Activity::updateActivityTemperature();
            Recruit::updateRecruitTemperature();
            News::updateNewsTemperature();
        })->hourly();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
