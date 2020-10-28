<?php

namespace App\Console;

use App\Jobs\DomainMonitor;
use App\Jobs\DomainRecordUpdater;
use App\Models\Domain;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // check websites update every five minutes
        $schedule->call(function () {
            $domains = Domain::select(['id', 'name'])->get();
            foreach ($domains as $domain) {
                dispatch(new DomainMonitor($domain));
            }
        })->everyFiveMinutes();

        // update all domain record every month
        if(!empty(env('WHOISXML_APIKEY'))) {
            $schedule->call(function () {
                $domains = Domain::select(['id', 'name'])->get();
                foreach ($domains as $domain) {
                    dispatch(new DomainRecordUpdater($domain));
                }
            })->monthly();
        }


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
