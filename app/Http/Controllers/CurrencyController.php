<?php

namespace App\Http\Controllers;

use App\Contracts\CurrencyServiceContract;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function convert(Request $request, CurrencyServiceContract $currencyService)
    {
        return $currencyService->convert($request->from, $request->to);
    }

    public function symbols(CurrencyServiceContract $currencyService)
    {
        return $currencyService->getSymbols();
    }
}
