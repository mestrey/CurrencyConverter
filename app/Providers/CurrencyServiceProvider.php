<?php

namespace App\Providers;

use App\Contracts\CurrencyServiceContract;
use App\Services\CurrencyService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CurrencyServiceContract::class, function () {
            return new CurrencyService(env('API_URL'));
        });
    }

    public function boot()
    {
    }
}
