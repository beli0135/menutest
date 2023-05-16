<?php

use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('exchange-rates',[CurrencyController::class,'getCurrencyExchangeRates']);
Route::post('update-exchange-rates',[CurrencyController::class,'updateCurrencyExchangeRates']);
