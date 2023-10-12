<?php

namespace App\Support\Database;

class Table
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
