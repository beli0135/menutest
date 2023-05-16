<?php

namespace Database\Factories;

use App\Enums\ActionEnum;
use App\Services\CurrencyService;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $currencies = Cache::remember('currencies-cache', now()->addHour(), function () {
            return DB::table('currencies')->orderBy('currency')->get();
        });

        $orderService = new OrderService();
        $currency = $currencies->random();
        $amount = random_int(100, 99999);

        $calc = $orderService->getCalculationResult(
            $amount,
            $currency->rate,
            $currency->surcharge_pct,
            $currency->discount_pct,
        );

        return [
            'currency' => $currency->currency,
            'rate' => $currency->rate,
            'surcharge_pct' => $currency->surcharge_pct,
            'surcharge' => $calc['surcharge'],
            'purchased' => $amount,
            'paid' => $calc['total_USD'],
            'discount_pct' => $currency->discount_pct,
            'discount' => $calc['discount_USD'],
            'action' => ActionEnum::AE_SEEDED,
        ];
    }
}
