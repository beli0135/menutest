<?php

namespace App\Services;

use GuzzleHttp\Client;


class CurrencyService
{
    public function __construct(
        private string $apiKey = 'XxeetIVgYJlI4k3e7sc9wh1OyOsuSdqw33eMc95R'
    ) {
    }

    public function getCurrencyExchangeRate(string $from, string $to): array
    {
        $url = 'https://api.freecurrencyapi.com/v1/latest?apikey=' . $this->apiKey .
            '&base_currency=' . $from . '&currencies=' . $to;

        $httpClient = new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $response = $httpClient->get($url);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }
}