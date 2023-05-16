<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Console\Command;

class updateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates exchange rates for JPY, GBP and EUR with USD as a base';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new CurrencyService();

        $data = $service->getCurrencyExchangeRate('USD', 'JPY,GBP,EUR');
        if (empty($data)) {
            $this->error('Exchange API service is unreachable');
            $this->newLine();
            return;
        }

        foreach ($data as $key => $value) {
            Currency::where('currency', '=', $key)->update(['rate' => $value]);
        }

        $this->info('Exchange rate update is completed!');
        $this->newLine();
    }
}
