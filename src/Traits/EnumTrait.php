<?php

namespace Mantax559\LaravelHelpers\Traits;

use Exception;

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

    public static function getEnumByString(string $string): self
    {
        foreach (self::cases() as $value) {
            if (cmprstr($value->value, $string)) {
                return $value;
            }
        }

        throw new Exception("$string is not a valid backing value for enum " . self::class);
    }
}
