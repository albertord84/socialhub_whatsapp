<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DCzajkowski\AuthTests\Console\Commands\AuthTestsMakeCommand;

class AuthTestsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AuthTestsMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
