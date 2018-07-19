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
         Socialite::extend('passport', function () {
             $config = $this->app['config']['services.passport'];
             $provider = Socialite::buildProvider(PassportProvider::class, $config);
             $provider->serverUrl($config['server_url']);
             return $provider;
         });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
     public function register()
     {
         //
     }
}
