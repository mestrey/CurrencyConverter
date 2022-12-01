<?php

namespace App\Contracts;

interface CurrencyServiceContract
{
    public function __construct(string $baseUrl);

    public function convert(string $from, string $to);
}
