<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TelescopeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Only register Telescope if installed (Laravel 8 compatible)
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\Telescope::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
    }

    public function boot()
    {
        //
    }
}