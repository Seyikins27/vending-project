<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[AuthController::class,'login']);
Route::post('user/register',[UserController::class,'register']);

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::get('user/wallet/balance',[UserWalletController::class,'balance']);
    Route::get('user/wallet/transactions',[UserWalletController::class,'transactions']);
    Route::post('user/wallet/topup',[UserWalletController::class,'topup']);
    Route::post('user/airtime/vend',[UserController::class,'purchase_airtime']);
});

