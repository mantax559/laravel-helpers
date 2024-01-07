<?php

namespace Mantax559\LaravelHelpers\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    private const CONFIG_FILE = __DIR__.'/../../config/laravel-helpers.php';

    private const PATH_VIEWS = __DIR__.'/../../resources/views';

    public function boot(): void
    {
        $this->publishes([
            self::CONFIG_FILE => config_path('laravel-helpers.php'),
        ], 'config');

        $this->loadViewsFrom(self::PATH_VIEWS, 'laravel-helpers');

        Blade::componentNamespace('Mantax559\\LaravelHelpers\\View\\Components\\Forms', 'form');

        // TODO: Move to seperate class
        Builder::macro('whereLike', function ($attributes, string $search) {
            $this->where(function (Builder $query) use ($attributes, $search) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $search) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $search) {
                                $query->where($relationAttribute, 'LIKE', "%{$search}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $search) {
                            $query->orWhere($attribute, 'LIKE', "%{$search}%");
                        }
                    );
                }
            });

            return $this;
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'laravel-helpers');
    }
}
