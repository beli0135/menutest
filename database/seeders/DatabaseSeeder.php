<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public static function seedCurrencies()
    {
        DB::table('currencies')->insert([
            'currency' => 'JPY',
            'name' => 'Japanese Yen',
            'surcharge_pct' => 7.5,
            'rate' => 107.17,
            'discount_pct' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('currencies')->insert([
            'currency' => 'GBP',
            'name' => 'British Pound',
            'surcharge_pct' => 5,
            'discount_pct' => 0,
            'rate' => 0.711178,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('currencies')->insert([
            'currency' => 'EUR',
            'name' => 'Euro',
            'surcharge_pct' => 5,
            'rate' => 0.884872,
            'discount_pct' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function run(): void
    {
        $this->seedCurrencies();
        Order::factory(30)->create();
    }
}
