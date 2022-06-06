<?php

use Illuminate\Support\Facades\Route;
use App\Models\Emp;
use App\Models\Dept;
use App\Models\Role;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/test', function () {
    Mail::to('test@example.com', 'Test')->send(new TestMail);
    return 'メール送信しました！';
});


//基本の書き方 laravel9版
use App\Http\Controllers\TestController;
    Route::controller(TestController::class)->group(function () {
    // Route::get('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
    Route::get('/list1', 'list1')->name('list1');
    Route::post('/list1', 'list1')->name('list1');
    Route::get('/list2', 'list2')->name('list2');
    Route::post('/list2', 'list2')->name('list2');
    Route::post('/edit1', 'edit1')->middleware(['edit']);;
    Route::post('/editcheck1', 'editcheck1');
    Route::post('/edit2', 'edit2')->middleware(['edit']);;
    Route::post('/editcheck2', 'editcheck2');
    Route::post('/insert1', 'insert1')->middleware(['insert']);
    Route::post('/insert2', 'insert2')->middleware(['insert']);
    Route::post('/delete1', 'delete1')->middleware(['delete']);
    Route::post('/delete2', 'delete2')->middleware(['delete']);
    Route::post('/enamesearch', 'enamesearch');
    Route::post('/salsearch', 'salsearch');
    Route::post('/dnamesearch', 'dnamesearch');
    Route::post('/empcsvd', 'empcsvd')->middleware(['csvdown']);
    Route::post('/empcsvin', 'empcsvin')->middleware(['csvup']);
    Route::post('/deptcsvd', 'deptcsvd')->middleware(['csvdown']);
    Route::post('/deptcsvin', 'deptcsvin')->middleware(['csvup']);
    Route::post('/tuikaimg1', 'tuikaimg1')->middleware(['imgup']);
    Route::post('/tuikaimg2', 'tuikaimg2')->middleware(['imgup']);
    Route::post('/imgdelete1', 'imgdelete1')->middleware(['imgdelete']);
    Route::post('/imgdelete2', 'imgdelete2')->middleware(['imgdelete']);
    Route::post('/role_change', 'role_change')->middleware(['rolechange']);
    Route::get('/log', 'log')->name('log');
    Route::post('/logserch', 'logserch');
    Route::post('/logcsvd', 'logcsvd');
    Route::get('/schedule', 'schedule')->name('schedule');
    Route::post('/schedule', 'schedule')->name('schedule');
    Route::post('/setting1', 'setting1');
    Route::post('/setting2', 'setting2');
    Route::post('/setting3', 'setting3');
    Route::get('/mail', 'send');

    Route::get('/aaa', 'aaa')->name('aaa');
    Route::post('/aaa', 'aaa')->name('aaa');
});

