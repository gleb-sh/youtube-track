<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ChannelController;


Route::get('login', function () {
    return view('login');
})->middleware('NoAuth');



Route::middleware('Auth')->group(function() {

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/gr/{group}',[GroupController::class,'show']);

    Route::get('/ch/{channel}',[ChannelController::class,'show']);

    Route::get('settings', function () {
        return view('settings');
    });


    // api

    Route::post('api/getstats',[VideoController::class,'getAll']);



});
