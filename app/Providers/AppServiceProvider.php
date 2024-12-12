<?php

namespace App\Providers;

use App\ScoutEngines\SphinxEngine;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SphinxEngine::class, function ($app) {
            return new SphinxEngine();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
