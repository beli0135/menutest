<?php

use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    $currencies = CurrencyController::fetchCurrencies();
    return view('index', compact('currencies'));
})->name('home');

Route::post('calculate', [OrderController::class, 'calculate'])->name('calculate');
Route::put('create-order', [OrderController::class, 'createOrder'])->name('createOrder');
Route::get('ordergrid',[OrderController::class,'showGrid'])->name('ordergrid');
Route::post('fetch-currencies', [CurrencyController::class, 'fetchCurrencies'])->name('fetchCurrencies');
