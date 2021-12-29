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
    return view('index');
})->name('index');

Route::name('admin.')->prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::resource('lottery',\App\Http\Controllers\Admin\LotteryController::class);
    Route::get('do-lottery/{lottery}',[\App\Http\Controllers\Admin\LotteryController::class,'doLottery'])->name('lottery.run');
    Route::get('winners/{lottery}',[\App\Http\Controllers\Admin\LotteryController::class,'winnersList'])->name('lottery.winners');

    Route::get('users',[\App\Http\Controllers\Admin\UserController::class,'index'])->name('users.index');
});


Auth::routes();

Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class,'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
