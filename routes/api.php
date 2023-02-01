<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\WithdrawalsController;


Route::prefix('providers')->group(function(){
    Route::post('/reply',[ProvidersController::class,'replyProvider']);
});

Route::prefix('clients')->group(function(){
    Route::post('/reply',[ClientsController::class,'replyClients']);
    Route::post('/conditionSpecial',[ClientsController::class,'conditionSpecial']);
    Route::post('/refreshLoyaltyCard',[ClientsController::class,'refreshLoyaltyCard']);
});

Route::prefix('products')->group(function(){
    Route::post('/',[ProductsController::class,'index']);
    Route::post('/pairing',[ProductsController::class,'pairingProducts']);
    Route::post('/replaceProducts',[ProductsController::class,'replaceProducts']);
    Route::post('/highProducts',[ProductsController::class,'highProducts']);
    Route::post('/highPrices',[ProductsController::class,'highPrices']);
    Route::post('/highPricesForeign',[ProductsController::class,'highPricesForeign']);
    Route::post('/insertPub',[ProductsController::class,'insertPub']);
    Route::post('/insertPricesPub',[ProductsController::class,'insertPricesPub']);
    Route::post('/insertPubProducts',[ProductsController::class,'insertPubProducts']);
    Route::post('/insertPricesProductPub',[ProductsController::class,'insertPricesProductPub']);
    Route::post('/replyProducts',[ProductsController::class,'replyProducts']);
    Route::post('/replyProductsPrices',[ProductsController::class,'replyProductsPrices']);
    Route::post('/additionalsBarcode',[ProductsController::class,'additionalsBarcode']);
});

Route::prefix('agents')->group(function(){
    Route::get('/',[AgentsController::class,'index']);
    // Route::post('/replyAgents',[AgentsController::class,'replyAgents']);
    Route::post('/replyuser',[AgentsController::class,'replyUser']);
    Route::post('/replyagents',[AgentsController::class,'replyAgents']);
});

Route::prefix('withdrawals')->group(function(){
    Route::get('/',[WithdrawalsController::class,'replyWitdrawal']);
});