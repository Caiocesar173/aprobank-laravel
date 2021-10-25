<?php

namespace Caiocesar173\Aprobank\Providers;

use Illuminate\Support\ServiceProvider;

class AprobankServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/aprobank.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'aprobank');
        $this->loadMigrationsFrom(__DIR__ .'/../../database/migrations');
    }
}