<?php

namespace Mantax559\LaravelHelpers\Providers;

use Carbon\Carbon;
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

        Builder::macro('whereDateAfter', function ($attributes, string $date) {
            $this->where($attributes, '>', Carbon::parse($date)->endOfDay());

            return $this;
        });

        Builder::macro('whereDateAfterOrEqual', function ($attributes, string $date) {
            $this->where($attributes, '>=', Carbon::parse($date)->endOfDay());

            return $this;
        });

        Builder::macro('whereDateBefore', function ($attributes, string $date) {
            $this->where($attributes, '<', Carbon::parse($date)->endOfDay());

            return $this;
        });

        Builder::macro('whereDateBeforeOrEqual', function ($attributes, string $date) {
            $this->where($attributes, '<=', Carbon::parse($date)->endOfDay());

            return $this;
        });
    }
}
