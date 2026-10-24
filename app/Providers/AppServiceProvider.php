<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;use Illuminate\Support\Facades\Hash;use App\Libraries\LegacyMd5BcryptHasher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        Hash::extend('legacy-md5-bcrypt', function ($app) {            return new LegacyMd5BcryptHasher($app['config']->get('hashing.bcrypt', []));        });
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
