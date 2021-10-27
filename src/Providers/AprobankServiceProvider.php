<?php

namespace Caiocesar173\Aprobank\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AprobankServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/aprobank.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'aprobank');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen(MigrationsStarted::class, function () {
            DB::statement('SET sql_require_primary_key=0;');
        });

        Event::listen(MigrationsEnded::class, function () {
            DB::statement('SET sql_require_primary_key=1;');
        });
    }
}
