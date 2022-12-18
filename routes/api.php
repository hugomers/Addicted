<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProductsController;



Route::prefix('providers')->group(function(){
    Route::post('/reply',[ProvidersController::class,'replyProvider']);
});

Route::prefix('clients')->group(function(){
    Route::post('/reply',[ClientsController::class,'replyClients']);
});

Route::prefix('products')->group(function(){
    Route::get('/',[ProductsController::class,'index']);
    Route::post('/pairing',[ProductsController::class,'pairingProducts']);
    Route::post('/replaceProducts',[ProductsController::class,'replaceProducts']);
    Route::post('/highProducts',[ProductsController::class,'highProducts']);
    Route::post('/highPrices',[ProductsController::class,'highPrices']);
    Route::post('/highPricesForeign',[ProductsController::class,'highPricesForeign']);
});