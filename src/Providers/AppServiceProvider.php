<?php

namespace Mantax559\LaravelHelpers\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

        $this->registerMacros();

        Blade::componentNamespace('Mantax559\\LaravelHelpers\\View\\Components\\Forms', 'form');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'laravel-helpers');
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

        Builder::macro('whenWhere', function ($attributes, ?string $search, string $condition = null) {
            if (! empty($search)) {
                if (! empty($condition)) {
                    $this->where($attributes, $condition, $search);
                } else {
                    $this->where($attributes, $search);
                }
            }

            return $this;
        });

        Builder::macro('whenWhereIn', function ($attributes, ?string $search) {
            if (! empty($search)) {
                $this->whereIn($attributes, $search);
            }

            return $this;
        });

        Builder::macro('whenWhereLike', function ($attributes, ?string $search) {
            if (! empty($search)) {
                $this->whereLike($attributes, $search);
            }

            return $this;
        });
    }
}
