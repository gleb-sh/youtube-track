<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ChanelController;
use App\Http\Controllers\UserController;




Route::middleware('NoAuth')->group(function() {

    Route::get('/', function () {
        return view('index');
    });

    Route::post('/api/login',[UserController::class,'login']);

});


Route::middleware('Auth')->group(function() {

    Route::get('logout',[UserController::class,'logout']);

    Route::get('/welcome',[GroupController::class,'showAll']);

    Route::get('/gr/{group}',[GroupController::class,'showOne']);

    Route::get('/ch/{channel}',[ChanelController::class,'show']);

    Route::get('settings', function () {
        return view('settings');
    });


    // api

    Route::post('api/group/create',[GroupController::class,'create']);
    Route::post('api/group/rename/{id}',[GroupController::class,'rename']);
    Route::post('api/group/delete/{id}',[GroupController::class,'delete']);


    Route::post('api/getstats',[VideoController::class,'getAll']);



});
