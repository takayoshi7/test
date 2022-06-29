<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB; //追加
use Illuminate\Support\Arr; //追加

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\LogDeletion::class, //起動したいコマンドファイル名
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) //ローカルで実行するためには「php artisan schedule:work」
    {
        $data = DB::table('schedulers')->select('num', 'interval', 'interval1', 'interval2', 'intervalhour')->where('name', 'log_delete')->get();
        $encode = json_decode(json_encode($data), true);
        $array = Arr::flatten($encode);
        $num = $array[0];
        $interval = $array[1];
        $interval1 = $array[2];
        $interval2 = $array[3];
        $intervalhour = $array[4];

        if ($num == 0) {
            if ($intervalhour == 1) {
                // $schedule->command('writelog')->everyMinute();
                $schedule->command('logdeletion')->everyMinute(); //毎分実行
            } else if ($intervalhour == 5) {
                // $schedule->command('writelog')->everyFiveMinutes();
                $schedule->command('logdeletion')->everyFiveMinutes(); //5分ごとに実行
            } else if ($intervalhour == 10) {
                // $schedule->command('writelog')->everyTenMinutes();
                $schedule->command('logdeletion')->everyTenMinutes(); //10分ごとに実行
            } else if ($intervalhour == 15) {
                // $schedule->command('writelog')->everyFifteenMinutes();
                $schedule->command('logdeletion')->everyFifteenMinutes(); //15分ごとに実行
            } else if ($intervalhour == 30) {
                // $schedule->command('writelog')->everyThirtyMinutes();
                $schedule->command('logdeletion')->everyThirtyMinutes(); //30分ごとに実行
            } else if ($intervalhour == 60) {
                // $schedule->command('writelog')->hourly();
                $schedule->command('logdeletion')->hourly(); //60分ごとに実行
            }
        } else {
            if ($num == 1) {
                if ($interval < 10) {
                    $time = "0" . (string)$interval . ":00";
                } else {
                    $time = $interval . ":00";
                }
                $schedule->command('logdeletion')->dailyAt($time); //毎日〇時に実行
            } else if ($num == 2) {
                $schedule->command('logdeletion')->twiceDaily($interval1, $interval2);; //毎日〇時と〇時に実行
            }
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
