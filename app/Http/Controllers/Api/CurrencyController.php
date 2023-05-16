<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{

    public function __construct(
        private CurrencyService $currencyService,
    ) {
    }

    public function getCurrencyExchangeRates(): JsonResponse
    {
        $rates = $this->currencyService->getCurrencyExchangeRate('USD', 'JPY,GBP,EUR');
        if (empty($rates)) {
            $error = ['Error' => 'Exchange API service is unreachable'];
            return response()->json($error, 503);
        }
        return response()->json($rates, 200);
    }

    public function updateCurrencyExchangeRates(): JsonResponse
    {
        $rates = $this->currencyService->getCurrencyExchangeRate('USD', 'JPY,GBP,EUR');
        if (empty($rates)) {
            $error = ['Error' => 'Exchange API service is unreachable'];
            return response()->json($error, 503);
        }

        foreach ($rates as $key => $value) {
            Currency::where('currency', '=', $key)->update(['rate' => $value]);
        }

        return response()->json(['Success' => 'Exchange rates updated'], 200);
    }

    public static function fetchCurrencies()
    {
        return Cache::remember('currencies', now()->addHour(), function () {
            return DB::table('currencies')->orderBy('currency')->get(['currency', 'name']);
        });
    }
}
