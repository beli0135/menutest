<?php

namespace Tests\Feature;

use App\Models\Currency;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_exchange_rates_response_correct(): void
    {
        $response = $this->get('/api/exchange-rates');

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['JPY', 'EUR', 'GBP']));
    }

    public function test_exchange_rate_updates_correctly(): void
    {
        $currentRates = $this->get('/api/exchange-rates');
        DatabaseSeeder::seedCurrencies();
        $currency = Currency::find(1);
        $datetime = date_format($currency->updated_at, "Y/m/d H:i");

        $this->post('/api/update-exchange-rates');
        $currency = Currency::find(1);

        $this->assertEquals($datetime, date_format($currency->updated_at, "Y/m/d H:i"));
        $this->assertEquals($currentRates[$currency->currency], $currency->rate);
    }


}
