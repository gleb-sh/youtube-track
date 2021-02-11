<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;



Route::middleware('NoAuth')->group(function() {

    Route::get('/', function () {
        return view('index');
    });

    Route::post('/api/login',[UserController::class,'login']);

});



Route::middleware('Auth')->group(function() {

    Route::get('test/{name}',[ChannelController::class,'test']);
    Route::get('update/c',[ChannelController::class,'updateC']);
    Route::get('update/l',[ChannelController::class,'updateL']);


    Route::get('logout',[UserController::class,'logout']);

    Route::get('/welcome',[GroupController::class,'showAll']);

    Route::get('/gr/{group}',[GroupController::class,'showOne']);

    Route::get('/ch/{id}',[ChannelController::class,'show']);

    Route::get('settings',[SettingsController::class,'show']);


    // api

    Route::post('api/group/create',[GroupController::class,'create']);
    Route::post('api/group/rename/{id}',[GroupController::class,'rename']);
    Route::post('api/group/delete/{id}',[GroupController::class,'delete']);

    Route::post('api/channel/add',[ChannelController::class,'add']);
    Route::post('api/channel/delete/{id}',[ChannelController::class,'delete']);

    Route::post('api/getstats/{id}',[ChannelController::class,'getstats']);

    Route::post('api/settings',[SettingsController::class,'rewrite']); 

});
