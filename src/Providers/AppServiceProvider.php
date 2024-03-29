<?php

namespace Mantax559\LaravelHelpers\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    private const PATH_CONFIG = __DIR__.'/../../config/laravel-helpers.php';

    private const PATH_VIEWS = __DIR__.'/../../resources/views';

    public function boot(): void
    {
        $this->publishes([
            self::PATH_CONFIG => config_path('laravel-helpers.php'),
        ], 'config');

        $this->loadViewsFrom(self::PATH_VIEWS, 'laravel-helpers');

        $this->registerMacros();

        Blade::componentNamespace('Mantax559\\LaravelHelpers\\View\\Components\\Forms', 'form');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::PATH_CONFIG, 'laravel-helpers');
    }

    private function registerMacros(): void
    {
        Builder::macro('whereLike', function ($columns, string $value) {
            $this->where(function (Builder $query) use ($columns, $value) {
                foreach (Arr::wrap($columns) as $column) {
                    $query->when(
                        Str::contains($column, '.'),
                        function (Builder $query) use ($column, $value) {
                            $parts = explode('.', $column);
                            $relationColumn = array_pop($parts);
                            $relationName = implode('.', $parts);

                            return $query->orWhereHas(
                                $relationName,
                                function (Builder $query) use ($relationColumn, $value) {
                                    $query->where($relationColumn, 'LIKE', "%{$value}%");
                                }
                            );
                        },
                        function (Builder $query) use ($column, $value) {
                            return $query->orWhere($column, 'LIKE', "%{$value}%");
                        }
                    );
                }
            });

            return $this;
        });
    }
}
