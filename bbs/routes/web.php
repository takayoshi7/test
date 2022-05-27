<?php

use Illuminate\Support\Facades\Route;
use App\Models\Emp;
use App\Models\Dept;
use App\Models\Role;

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
    Route::get('/list1', 'list1')->name('list1');
    Route::post('/list1', 'list1')->name('list1');
    Route::get('/list2', 'list2')->name('list2');
    Route::post('/list2', 'list2')->name('list2');
    Route::post('/edit1', 'edit1');
    Route::post('/editcheck1', 'editcheck1');
    Route::post('/edit2', 'edit2');
    Route::post('/editcheck2', 'editcheck2');
    Route::post('/insert1', 'insert1');
    Route::post('/insert2', 'insert2');
    Route::post('/delete1', 'delete1');
    Route::post('/delete2', 'delete2');
    Route::post('/enamesearch', 'enamesearch');
    Route::post('/salsearch', 'salsearch');
    Route::post('/dnamesearch', 'dnamesearch');
    Route::post('/empcsvd', 'empcsvd');
    Route::post('/empcsvin', 'empcsvin');
    Route::post('/deptcsvd', 'deptcsvd');
    Route::post('/deptcsvin', 'deptcsvin');
    Route::post('/tuikaimg1', 'tuikaimg1');
    Route::post('/tuikaimg2', 'tuikaimg2');
    Route::post('/imgdelete1', 'imgdelete1');
    Route::post('/imgdelete2', 'imgdelete2');
    Route::post('/role_change', 'role_change');

    Route::get('/aaa', 'aaa')->name('aaa');
    Route::post('/aaa', 'aaa')->name('aaa');
});

