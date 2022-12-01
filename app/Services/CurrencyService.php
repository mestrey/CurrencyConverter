<?php

namespace App\Services;

use App\Contracts\CurrencyServiceContract;
use Illuminate\Support\Facades\Http;

class CurrencyService implements CurrencyServiceContract
{
    public function __construct(
        private string $baseUrl
    ) {
    }

    public function convert(string $from, string $to)
    {
        return Http::acceptJson()
            ->get($this->baseUrl . '/convert', [
                'from' => $from,
                'to' => $to,
            ])
            ->json();
    }

    public function getSymbols()
    {
        return Http::acceptJson()
            ->get($this->baseUrl . '/symbols')
            ->json();
    }
}
