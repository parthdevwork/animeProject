<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimiterServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot()
    {

        RateLimiter::for('importAnimeData', function () {
            return Limit::perMinute(1);
        });

        RateLimiter::for('getAnimeBySlug', function () {
            return Limit::perSecond(1);
        });
    }
}
