<?php

namespace App\Services;

use App\Enums\ActionEnum;
use App\Helpers\AppHelper;
use App\Mail\NotificationMailGBP;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function getCalculationResult(
        float $purchased,
        float $rate,
        float $surcharge_pct,
        float $discount_pct
    ): array {
        $purchased = AppHelper::truncToTwoDecimals($purchased);
        $surcharge = AppHelper::truncToTwoDecimals($purchased * ($surcharge_pct / 100));
        $surcharged = $surcharge + $purchased;

        //convert surcharged amount to USD
        $undiscountedUSD = AppHelper::truncToTwoDecimals($surcharged / $rate);

        ($discount_pct == 0)
            ? $discountUSD = 0
            : $discountUSD = AppHelper::truncToTwoDecimals(($purchased * ($discount_pct / 100)) / $rate);

        $totalUSD = $undiscountedUSD - $discountUSD;

        return [
            'purchased' => $purchased,
            'rate' => $rate,
            'surcharge_pct' => $surcharge_pct,
            'surcharge' => $surcharge,
            'surcharged' => $surcharged,
            'surcharged_USD' => $undiscountedUSD,
            'discount_pct' => $discount_pct,
            'discount_USD' => $discountUSD,
            'total_USD' => $totalUSD,
        ];
    }

    public function afterCreate(Order $order): void
    {
        if ($order->currency == 'GBP') {
            if ($order->action !== ActionEnum::AE_MAILED) {
                $mailer = new NotificationMailGBP($order);
                Mail::send($mailer);
            }
            $order->update(['action' => ActionEnum::AE_MAILED]);
        }
    }

}