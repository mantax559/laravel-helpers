<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function convertDateToUTC(Carbon|string $date, string $fromTimezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, $fromTimezone, 'UTC', $formatToString);
    }

    public static function convertDateFromUTC(Carbon|string $date, string $toTimezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'UTC', $toTimezone, $formatToString);
    }

    public static function convertDateToGMT(Carbon|string $date, string $fromTimezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, $fromTimezone, 'GMT', $formatToString);
    }

    public static function convertDateFromGMT(Carbon|string $date, string $toTimezone, bool $formatToString = true): Carbon|string
    {
        return self::convertDateToTimezone($date, 'GMT', $toTimezone, $formatToString);
    }

    public static function convertDateToTimezone(Carbon|string $date, string $fromTimezone, string $toTimezone, bool $formatToString): Carbon|string
    {
        $date = Carbon::parse($date, $fromTimezone)
            ->setTimezone($toTimezone);

        if ($formatToString) {
            $date->toDateTimeString();
        }

        return $date;
    }
}
