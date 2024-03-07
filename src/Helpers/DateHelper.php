<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function toUtcString(Carbon $datetime): string
    {
        return $datetime->copy()->setTimezone('UTC')->toDateTimeString();
    }

    public static function fromUtcString(Carbon $datetime, string $timezone = 'UTC'): string
    {
        return $datetime->copy()->setTimezone($timezone)->toDateTimeString();
    }
}
