<?php

namespace App\Support;

use App\Support\Database\Table;

class SessionHelper
{
    public static function getUrlKey(string $model): string
    {
        return Table::getName($model) . '_page_url';
    }

    public static function setDefaultUrlIfEmpty(string $model, string $route): void
    {
        if (session()->missing(self::getUrlKey($model))) {
            session()->put(self::getUrlKey($model), route($route));
        }
    }
}
