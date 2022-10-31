<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Lib\ILogger::class, function() {
            return new \App\Lib\DBLogger;
        });        
        $this->app->bind(\App\Lib\Message\Imessage::class, function() {
            return new \App\Lib\Message\MessageFactory;
        }); 

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
