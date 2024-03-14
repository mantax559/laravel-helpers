<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function convertDateToUTC(Carbon $date, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'UTC', $formatToString);
    }

    public static function convertDateFromUTC(Carbon $date, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'UTC', $formatToString);
    }

    public static function convertDateToGMT(Carbon $date, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'GMT', $formatToString);
    }

    public static function convertDateFromGMT(Carbon $date, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'GMT', $formatToString);
    }

    public static function convertDateToTimezone(Carbon $date, string $toTimezone, bool $formatToString): Carbon|string
    {
        $date = $date->setTimezone($toTimezone);

        if ($formatToString) {
            $date->toDateTimeString();
        }

        return $date;
    }
}
