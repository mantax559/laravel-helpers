<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function convertDateToUTC(string|Carbon $date, string $timezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, $timezone, 'UTC', $formatToString);
    }

    public static function convertDateFromUTC(string|Carbon $date, string $timezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'UTC', $timezone, $formatToString);
    }

    public static function convertDateToGMT(string|Carbon $date, string $timezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, $timezone, 'GMT', $formatToString);
    }

    public static function convertDateFromGMT(string|Carbon $date, string $timezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'GMT', $timezone, $formatToString);
    }

    private static function convertDateToTimezone(string|Carbon $date, string $fromTimezone, string $toTimezone, bool $formatToString): Carbon|string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date, $fromTimezone);
        } else {
            $date->setTimezone($fromTimezone);
        }

        $date->setTimezone($toTimezone);

        if ($formatToString) {
            return $date->toDateTimeString();
        }

        return $date;
    }
}
