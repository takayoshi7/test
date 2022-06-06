<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TestController; //追加

class LogDeletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logdeletion'; //コマンド名

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log Deletion'; //コマンド説明

    /**
     * Execute the console command.
     * @return void
     * @return int
     */
    public function handle()
    {
        TestController::logdeletion(); //自動実行したいコントローラーの処理名
        logger()->info('log delete complete');
    }
}
