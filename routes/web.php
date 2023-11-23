<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\lotteryController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\userController;
use App\Http\Controllers\cronController;

Route::get('/', [homeController::class, 'index'])->name('home');
Route::get('/cron', [cronController::class, 'index']);
Route::get('/newCron', [cronController::class, 'newIndex']);

Route::group(['middleware'=>['AdminCheck']], function(){
    Route::get('/admin', [adminController::class, 'login'])->name('admin.login');
    Route::post('/admin', [adminController::class, 'check'])->name('admin.check');
    // Route::post('/', [lotteryController::class, 'index'])->name('lottery');
    Route::match(['get','post'], '/reserve', [adminController::class, 'reserve'])->name('admin.reserve');
    Route::match(['get','post'], '/winning', [adminController::class, 'winning'])->name('admin.winning');
    Route::match(['post'], '/winningStatus', [adminController::class, 'winningStatus'])->name('admin.status');
    Route::match(['get','post'], '/combinations', [adminController::class, 'combinations'])->name('admin.combinations');
    Route::match(['get','post'], '/filter_reserved', [adminController::class, 'filterReserved'])->name('admin.filterReserved');
    Route::match(['get','post'], '/filter_consecutive', [adminController::class, 'filterConsecutive'])->name('admin.filterConsecutive');
    
    Route::match(['get','post'], '/new_combinations', [adminController::class, 'newCombinations'])->name('admin.new_combinations');
    Route::match(['get','post'], '/new_filter_reserved', [adminController::class, 'newFilterReserved'])->name('admin.new_filterReserved');
    Route::match(['get','post'], '/new_filter_consecutive', [adminController::class, 'newFilterConsecutive'])->name('admin.new_filterConsecutive');
     Route::match(['get','post'], '/new_winning', [adminController::class, 'new_winning'])->name('admin.new_winning');
     Route::match(['post'], '/newWinningStatus', [adminController::class, 'newWinningStatus'])->name('admin.newStatus');
    
    Route::match(['get','post'], '/play', [adminController::class, 'play'])->name('admin.play');
    Route::match(['get','post'], '/newPlay', [adminController::class, 'newPlay'])->name('admin.newPlay');
    
    Route::get('/users', [adminController::class, 'users'])->name('admin.users');
    Route::get('/logout', [adminController::class, 'logout'])->name('admin.logout');
});

Route::group(['middleware'=>['UserCheck']], function(){
    Route::get('/user', [userController::class, 'login'])->name('user.login');
    Route::post('/user', [userController::class, 'check'])->name('user.check');
    Route::match(['get','post'], '/user-play', [userController::class, 'play'])->name('user.play');
    Route::get('/user-played', [userController::class, 'played'])->name('user.played');
    Route::match(['get','post'], '/user-new-play', [userController::class, 'play'])->name('user.newPlay');
    Route::get('/user-logout', [userController::class, 'logout'])->name('user.logout');
});

Route::get('/signup', [userController::class, 'signup'])->name('user.signup');
Route::post('/signup', [userController::class, 'checkSignup'])->name('user.checkSignup');
