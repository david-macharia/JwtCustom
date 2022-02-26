<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckJwtPresence;
use App\Http\Middleware\CheckRefreshJwtPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('checkJwt')->group(function (){

//     Route::post("/test",[UserController::class,'testApi']);

// });

Route::post("/refreshToken",[UserController::class,'refreshToken'])->middleware('refreshJwt');
// Route::post("/login",[UserController::class,'login']);