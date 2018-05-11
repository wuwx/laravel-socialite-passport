<?php

namespace Wuwx\LaravelSocialitePassport;

use Illuminate\Support\ServiceProvider;
use Socialite;

class LaravelSocialitePassportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
     public function register()
     {
         Socialite::extend('passport', function() {
             $config = $this->app['config']['services.passport'];
             return new PassportProvider(app('request'), $config['client_id'], $config['client_secret'], route('login') . "/passport/callback");
         });
     }
}
