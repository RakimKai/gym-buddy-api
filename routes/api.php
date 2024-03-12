<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('/posts', PostController::class);
    Route::get('/getAllPosts',[PostController::class,'getAll']);

    Route::resource('/memberships', MembershipController::class);
    Route::post('/memberships/storeAsEmployee',[MembershipController::class,'storeAsEmployee']);
    Route::get('/getAllMemberships',[MembershipController::class,'getAll']);
    Route::get('/getAllByMember',[MembershipController::class,'getAllByMember']);
    Route::post('/search',[MembershipController::class,'search']);
    
    Route::post('/enterGym',[CounterController::class,'enterGym']);
    Route::delete('/exitGym',[CounterController::class,'exitGym']);

    Route::post('order/pay',[PaymentController::class,'payByStripe']);

    Route::group(['prefix'=>'user'],function(){
        Route::post('/logout',[UserController::class,'logout']);
        Route::put('/update',[UserController::class,'update']);
        Route::get('/get',[UserController::class,'get']);
    });
});


