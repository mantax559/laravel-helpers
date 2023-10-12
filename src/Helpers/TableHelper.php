<?php

namespace Mantax559\LaravelHelpers\Helpers;

class TableHelper
{
    public static function getName(string $model): string
    {
        return (new $model())->getTable();
    }

    public static function getForeignKey(string $model): string
    {
        return (new $model())->getForeignKey();
    }
}
