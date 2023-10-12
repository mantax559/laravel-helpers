<?php

namespace Mantax559\LaravelHelpers\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const CONFIG_FILE = __DIR__.'/../../config/laravel-helpers.php';

    private const PATH_VIEWS = __DIR__.'/../../resources/views';

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_FILE => config_path('laravel-helpers.php'),
            ], 'config');
        }

        $this->loadViewsFrom(self::PATH_VIEWS, 'laravel-helpers');

        $this->registerComponents()->registerComponentsPublishers();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'laravel-helpers');
    }

    private function registerComponents(): self
    {
        Blade::componentNamespace('App\\View\\Components\\Forms', 'form');

        return $this;
    }

    public function registerComponentsPublishers(): self
    {
        $this->publishes([
            self::PATH_VIEWS => resource_path('views/vendor/laravel-helpers'),
        ], 'components');

        $this->publishes([
            self::PATH_VIEWS . '/form' => resource_path('views/vendor/laravel-helpers/form'),
        ], 'form-components');

        return $this;
    }
}
