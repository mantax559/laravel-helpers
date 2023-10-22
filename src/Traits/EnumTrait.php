<?php

namespace Mantax559\LaravelHelpers\Traits;

trait EnumTrait
{
    public static function getArray(): array
    {
        $array = [];

        foreach (self::cases() as $value) {
            $array[$value->value] = __($value->name);
        }

        return $array;
    }

    public static function getArrayForSelect(): array
    {
        $array = [];

        foreach (self::getArray() as $value => $name) {
            $array[] = [
                'id' => $value,
                'text' => $name,
            ];
        }

        return $array;
    }
}
