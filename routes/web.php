<?php

use App\Http\Controllers\MainController;

use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function(){
    Route::get('/', 'home')->name('home');
    Route::post('/', 'prepareGame')->name('prepareGame');
    Route::get('/game', 'game')->name('game');
});
