<?php

namespace Mantax559\LaravelHelpers\Helpers;

class SessionHelper
{
    public static function getUrlKey(string $model): string
    {
        return TableHelper::getName($model).'_page_url';
    }

    public static function setDefaultUrlIfEmpty(string $model, string $route, ?string $permission): void
    {
        $urlKey = self::getUrlKey($model);

        if (empty($permission)) {
            if (session()->missing($urlKey)) {
                session()->put($urlKey, route($route));
            }
        } else {
            if (auth()->check() && auth()->user()->can($permission)) {
                session()->put($urlKey, route($route));
            } else {
                session()->forget($urlKey, route($route));
            }
        }
    }
}
