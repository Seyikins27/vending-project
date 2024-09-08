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
    Route::post('user/wallet/topup',[UserWalletController::class,'topup']);
    Route::post('user/airtime/topup',[UserController::class,'purchase_airtime']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('vend',function(\Seyi\AirtimeVend\Airtime $airtime){
//     //return $airtime->vend();
// });
