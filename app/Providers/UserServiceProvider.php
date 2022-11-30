<?php

namespace App\Providers;

use App\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
    }

    public function boot()
    {
    }
}
