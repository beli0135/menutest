<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\CurrencyController;
use App\Models\Currency;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {
    }

    public function calculate(Request $request): RedirectResponse|View
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|required|min:50|max:100000000',
        ], [
            'max' => 'Keep it down to 100M, Mr. Bezos',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $currency = Currency::query()
            ->where('currency', '=', $request->currency_dd)
            ->first();

        $calcData = $this->orderService->getCalculationResult(
            $request->amount,
            $currency->rate,
            $currency->surcharge_pct,
            $currency->discount_pct
        );
        $calcData['currency'] = $currency->currency;

        return view('index', compact('calcData'));
    }

    public function createOrder(Request $request)
    {
        if (!$request->purchased) {
            $message = "Error: Invalid request parameters";
            $currencies = CurrencyController::fetchCurrencies();
            return view('index', [$message, $currencies]);
        }

        $order = Order::create([
            'currency' => $request->currency,
            'rate' => $request->rate,
            'surcharge_pct' => $request->surcharge_pct,
            'surcharge' => $request->surcharge,
            'purchased' => $request->purchased,
            'paid' => $request->total_USD,
            'discount_pct' => $request->discount_pct,
            'discount' => $request->discount_USD,
        ]);

        $this->orderService->afterCreate($order);
        $message = 'Purchase successful';

        return redirect()->route('home')->withSuccess($message);
    }

    public function showGrid(): View
    {
        $data = Order::query()
            ->orderBy('updated_at', 'DESC')
            ->simplePaginate(20);

        return view('grid', compact('data'));
    }
}
