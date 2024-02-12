<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Public routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


//Protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('/posts', PostController::class);
    Route::group(['prefix'=>'user'],function(){
        Route::post('/logout',[UserController::class,'logout']);
        Route::put('/update',[UserController::class,'update']);
        Route::get('/get',[UserController::class,'get']);
    });
});


