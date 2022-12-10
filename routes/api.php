<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ClientsController;



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

Route::prefix('providers')->group(function(){
    Route::post('/reply',[ProvidersController::class,'replyProvider']);
});

Route::prefix('clients')->group(function(){
    Route::post('/reply',[ClientsController::class,'replyClients']);
});