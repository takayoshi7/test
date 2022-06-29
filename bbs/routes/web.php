<?php

use Illuminate\Support\Facades\Route;

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


//基本の書き方 laravel9版
use App\Http\Controllers\TestController;
    Route::controller(TestController::class)->group(function () {
    Route::get('/list1', 'list1')->middleware(['authoritycheck'])->name('list1');
    Route::get('/list11', 'list11')->middleware(['authoritycheck']);
    Route::get('/list100', 'list100')->middleware(['authoritycheck']);
    Route::post('/list1', 'list1')->middleware(['authoritycheck'])->name('list1');
    Route::get('/list2', 'list2')->middleware(['authoritycheck'])->name('list2');
    Route::post('/list2', 'list2')->middleware(['authoritycheck'])->name('list2');
    Route::get('/list22', 'list22')->middleware(['authoritycheck']);
    Route::get('/list200', 'list200')->middleware(['authoritycheck']);
    // Route::post('/list2all', 'list2all')->middleware(['authoritycheck']);
    Route::post('/edit1', 'edit1')->middleware(['authoritycheck'])->middleware(['edit']);
    Route::post('/edit2', 'edit2')->middleware(['authoritycheck'])->middleware(['edit']);
    Route::post('/insert1', 'insert1')->middleware(['authoritycheck'])->middleware(['insert']);
    Route::post('/insert2', 'insert2')->middleware(['authoritycheck'])->middleware(['insert']);
    Route::post('/delete1', 'delete1')->middleware(['authoritycheck'])->middleware(['delete']);
    Route::post('/delete2', 'delete2')->middleware(['authoritycheck'])->middleware(['delete']);
    Route::get('/list1/{ename}{minnum}{maxnum}', 'search1')->middleware(['authoritycheck']);
    Route::get('/dnamesearch', 'dnamesearch')->middleware(['authoritycheck']);
    Route::post('/empcsvd', 'empcsvd')->middleware(['csvdown']);
    Route::post('/empcsvin', 'empcsvin')->middleware(['csvup']);
    Route::post('/deptcsvd', 'deptcsvd')->middleware(['csvdown']);
    Route::post('/deptcsvin', 'deptcsvin')->middleware(['csvup']);
    Route::post('/tuikaimg1', 'tuikaimg1')->middleware(['imgup']);
    Route::post('/tuikaimg2', 'tuikaimg2')->middleware(['imgup']);
    Route::post('/imgdelete1', 'imgdelete1')->middleware(['imgdelete']);
    Route::post('/imgdelete2', 'imgdelete2')->middleware(['imgdelete']);
    Route::post('/role_change', 'role_change')->middleware(['authoritycheck'])->middleware(['rolechange']);
    Route::get('/log', 'log')->name('log');
    Route::get('/log2', 'log2');
    Route::get('/logsort', 'logsort');
    Route::get('/logserch', 'logserch');
    Route::post('/logcsvd', 'logcsvd')->middleware(['logcsvdown']);
    Route::get('/schedule', 'schedule')->middleware(['authoritycheck'])->name('schedule');
    Route::post('/setting1', 'setting1')->middleware(['authoritycheck']);
    Route::post('/setting2', 'setting2')->middleware(['authoritycheck']);
    Route::post('/setting3', 'setting3')->middleware(['authoritycheck']);
    Route::post('/enamechange', 'enamechange')->middleware(['namechange']);
    Route::post('/emailchange', 'emailchange')->middleware(['mailchange'])->middleware(['mailsend']);
    Route::post('/address/{zip}', 'address');
    Route::post('/numsortchange', 'numsortchange');
    Route::post('/addresschange', 'addresschange')->middleware(['addresschange']);
    Route::post('/phonechange', 'phonechange')->middleware(['phonechange']);



    Route::get('/aaa', 'aaa')->name('aaa');
    Route::post('/aaa', 'aaa')->name('aaa');
});

