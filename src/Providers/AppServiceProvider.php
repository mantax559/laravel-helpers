<?php

namespace Mantax559\LaravelHelpers\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const CONFIG_FILE = __DIR__ . '/../../config/laravel-helpers.php';

    private const PATH_VIEWS = __DIR__ . '/../../resources/views';

    public function boot(): void
    {
        $this->publishes([
            self::CONFIG_FILE => config_path('laravel-helpers.php'),
        ], 'config');

        $this->loadViewsFrom(self::PATH_VIEWS, 'laravel-helpers');

        $this->registerComponents();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'laravel-helpers');
    }

    private function registerComponents(): self
    {
        Blade::componentNamespace('Mantax559\\LaravelHelpers\\View\\Components\\Forms', 'form');

        return $this;
    }
}
