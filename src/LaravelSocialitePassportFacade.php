<?php

namespace Wuwx\LaravelSocialitePassport;

use Illuminate\Support\Facades\Facade;

class LaravelSocialitePassportFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LaravelSocialitePassport::class;
    }
}
