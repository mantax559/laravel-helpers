<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function sort($array, $on, $order = SORT_DESC): array
    {
        $newArray = [];
        $sortableArray = [];

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortableArray[$k] = $v2;
                        }
                    }
                } else {
                    $sortableArray[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortableArray);
                    break;
                case SORT_DESC:
                    arsort($sortableArray);
                    break;
            }

            foreach ($sortableArray as $k => $v) {
                $newArray[$k] = $array[$k];
            }
        }

        return $newArray;
    }

    public static function csvToArray(string $csvContent, string $separator = "\t"): array
    {
        $array = [];
        $lines = str_getcsv($csvContent, "\n");
        $keys = str_getcsv($lines[0], $separator);

        for ($i = 1; $i < count($lines); ++$i) {
            $array[] = array_combine(
                $keys,
                str_getcsv($lines[$i], "\t")
            );
        }

        return $array;
    }
}
