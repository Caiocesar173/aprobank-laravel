<?php

namespace Caiocesar173\Aprobank\Providers;

use Illuminate\Support\ServiceProvider;

class AprobankServiceProvider extends ServiceProvider
{
    public function boot()
    {
        self::loadRoutesFrom(__DIR__.'/../../routes/aprobank.php');
        self::loadViewsFrom(__DIR__.'/../../resources/views', 'aprobank');
    }
}