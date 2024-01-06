<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

// Strings
if (! function_exists('mb_ucfirst')) {
    function mb_ucfirst($value): string
    {
        return mb_strtoupper(mb_substr((string) $value, 0, 1)).mb_substr((string) $value, 1);
    }
}

if (! function_exists('mb_ucwords')) {
    function mb_ucwords($string): string
    {
        return mb_convert_case((string) $string, MB_CASE_TITLE, 'UTF-8');
    }
}

if (! function_exists('external_code')) {
    function external_code($code, $prefix = null, $hash = 'base64'): string
    {
        $external_code = isset($prefix)
            ? $prefix.$code
            : (string) $code;

        $external_code = mb_strtolower(preg_replace('/\s+/', '', $external_code));

        if (cmprstr($hash, 'base64')) {
            return base64_encode($external_code);
        } elseif (cmprstr($hash, 'md5')) {
            return md5($external_code);
        } else {
            return $external_code;
        }
    }
}

if (! function_exists('external_code_decode')) {
    function external_code_decode($external_code): string
    {
        return base64_decode($external_code);
    }
}

if (! function_exists('price')) {
    function price($price, string $currency = 'EUR', int $decimals = 2): string
    {
        return number_format((float) $price, $decimals, '.', '').' '.$currency;
    }
}

if (! function_exists('seconds')) {
    function seconds($seconds, int $decimals = 4): string
    {
        return number_format((float) $seconds, $decimals, '.', '').'s';
    }
}

if (! function_exists('percentage')) {
    function percentage($percentage, int $decimals = 2): string
    {
        return number_format((float) $percentage, $decimals, '.', '').'%';
    }
}

if (! function_exists('slugify')) {
    function slugify($string): string
    {
        //return (new SlugGenerator())->generate((string)$string);
    }
}

if (! function_exists('escape_html')) {
    function escape_html($text): string
    {
        $ampersands = [
            '&nbsp;' => ' ',
            '&amp;' => '&',
            '&lt;' => '<',
            '&gt;' => '>',
            '&quot;' => '"',
            '&#039;' => "'",
        ];

        foreach ($ampersands as $encoded => $ampersand) {
            $text = str_replace($encoded, $ampersand, (string) $text);
        }

        return $text;
    }
}

if (! function_exists('trim_ean')) {
    function trim_ean($ean, $is_array = false): array|string|null
    {
        if (is_array($ean) || $is_array) {
            $array = [];

            foreach ($ean as $single_ean) {
                $ean = strtoint($single_ean);

                if (! empty($ean)) {
                    $array[] = $ean;
                }
            }

            if (empty($array)) {
                return null;
            }

            return $array;
        } else {
            $ean = strtoint($ean);

            if (empty($ean)) {
                return null;
            }

            return $ean;
        }
    }
}

if (! function_exists('format_string')) {
    function format_string($string, int|array $transforms = 0): ?string
    {
        $string = escape_html(trim((string) $string));

        if (! is_array($transforms)) {
            $transforms = [$transforms];
        }

        sort($transforms);

        foreach ($transforms as $transform) {
            $string = match ($transform) {
                1 => mb_ucfirst(mb_strtolower($string)),
                2 => mb_ucwords(mb_strtolower($string)),
                3 => mb_strtolower($string),
                4 => mb_strtoupper($string),
                5 => preg_replace('/[^0-9+]/', '', $string),
                6 => str_replace(['"', ',', '„', '”'], '', $string),
                7 => preg_replace('/\s+/', '', $string),
                8 => preg_replace('/[^a-zA-Z]+/', '', $string),
                0 => $string,
            };
        }

        $string = trim(preg_replace('/\s+/', ' ', $string));

        if (empty($string)) {
            return null;
        }

        return $string;
    }
}

if (! function_exists('str_pad_left')) {
    function str_pad_left(string $string, int $length = 2, string $pad_string = '0'): string
    {
        return str_pad($string, $length, $pad_string, STR_PAD_LEFT);
    }
}

if (! function_exists('array_to_string')) {
    function array_to_string(array $array): ?string
    {
        foreach ($array as $index => $item) {
            $array[$index] = format_string($item);
        }

        $string = format_string(implode('. ', array_filter($array, 'strlen')));

        return ! empty($string)
            ? $string.'.'
            : null;
    }
}

if (! function_exists('code_format')) {
    function code_format(string $prefix, string $code): string
    {
        return config($prefix).'-'.$code;
    }
}

if (! function_exists('bytes_conversion')) {
    function bytes_conversion(float $size): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        $power = is_positive_num($size)
            ? floor(log($size, 1024))
            : 0;

        return number_format($size / pow(1024, $power), 2, '.', '').' '.$units[$power];
    }
}

if (! function_exists('file_size')) {
    function file_size(string $file_path): string
    {
        try {
            return bytes_conversion(Storage::disk('file')->size($file_path));
        } catch (Exception $e) {
            return bytes_conversion(0);
        }
    }
}

if (! function_exists('file_last_modified')) {
    function file_last_modified(string $file_path): string
    {
        try {
            return Carbon::parse(Storage::disk('file')->lastModified($file_path))->toDateTimeString();
        } catch (Exception $e) {
            return '-';
        }
    }
}

// Arrays
if (! function_exists('unique_multidim_array')) {
    function unique_multidim_array($data, $first_key, $second_key): array
    {
        foreach ($data as $first_item) {
            $found = false;
            foreach ($data as $index => $second_item) {
                if (cmprstr($first_item[$first_key], $second_item[$first_key]) && cmprstr($first_item[$second_key], $second_item[$second_key])) {
                    if ($found) {
                        unset($data[$index]);
                    } else {
                        $found = true;
                    }
                }
            }
        }

        return array_values($data);
    }
}

if (! function_exists('unique_array')) {
    function unique_array($data, $key): array
    {
        foreach ($data as $first_item) {
            $found = false;
            foreach ($data as $index => $second_item) {
                if (cmprstr($first_item[$key], $second_item[$key])) {
                    if ($found) {
                        unset($data[$index]);
                    } else {
                        $found = true;
                    }
                }
            }
        }

        return $data;
    }
}

if (! function_exists('array_flip_by_key')) {
    function array_flip_by_key($data, $key): array
    {
        $array = [];

        if (! $data) {
            return $array;
        }

        foreach ($data as $item) {
            $array[$item[$key]] = $item;
        }

        return $array;
    }
}

// Numbers
if (! function_exists('array_sum_by_key')) {
    function array_sum_by_key(array $array, string $key): int
    {
        $sum = 0;

        foreach ($array as $item) {
            $sum += $item[$key];
        }

        return $sum;
    }
}

if (! function_exists('strtoint')) {
    function strtoint($string): int
    {
        return (int) preg_replace('/[^0-9]/', '', (string) $string);
    }
}

if (! function_exists('positive_num')) {
    function positive_num($number): float|int
    {
        return abs($number);
    }
}

if (! function_exists('negative_num')) {
    function negative_num($number): float|int
    {
        return -1 * abs($number);
    }
}

if (! function_exists('change_num_sign')) {
    function change_num_sign($number): float|int
    {
        return 0 - $number;
    }
}

if (! function_exists('words2bytes')) {
    function words2bytes($val): int
    {
        $val = mb_strtolower(trim($val));

        $unit = mb_substr($val, -1, 1);
        $val = mb_substr($val, 0, -1);

        if (cmprstr($unit, 'g')) {
            $val *= 1024 * 1024 * 1024;
        } elseif (cmprstr($unit, 'm')) {
            $val *= 1024 * 1024;
        } elseif (cmprstr($unit, 'k')) {
            $val *= 1024;
        } else {
            return 0;
        }

        return (int) $val;
    }
}

if (! function_exists('image_height')) {
    function image_height($image_path): int
    {
        try {
            return getimagesize(Storage::disk('file')->path((string) $image_path))[1];
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (! function_exists('image_width')) {
    function image_width($image_path): int
    {
        try {
            return getimagesize(Storage::disk('file')->path((string) $image_path))[0];
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (! function_exists('calc_execution_time')) {
    function calc_execution_time($time_start): float
    {
        return number_format(microtime(true) - (float) $time_start, 4, '.', '');
    }
}

if (! function_exists('date_to_jde_jd')) {
    function date_to_jde_jd(string $date): string
    {
        $date_obj = Carbon::parse($date);
        $century = floor(($date_obj->year - 1900) / 100);

        return $century
            .$date_obj->format('y')
            .str_pad($date_obj->dayOfYear, 3, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('jde_jd_to_date')) {
    function jde_jd_to_date(string $julian_date): string
    {
        $julian_date = str_pad($julian_date, 6, '0', STR_PAD_LEFT);

        return Carbon::parse('1900-01-01')
            ->addCenturies((int) substr($julian_date, 0, 1))
            ->addYears((int) substr($julian_date, 1, 2))
            ->addDays((int) substr($julian_date, 3, 3))
            ->subDay()
            ->toDateString();
    }
}

// Boolean
if (! function_exists('cmprbool')) {
    function cmprbool($value1, $value2): bool
    {
        return (bool) $value1 === (bool) $value2;
    }
}

if (! function_exists('cmprflt')) {
    function cmprflt($number1, $number2, int $decimals = 2): bool
    {
        return round((float) $number1, $decimals) === round((float) $number2, $decimals);
    }
}

if (! function_exists('cmprint')) {
    function cmprint($number1, $number2): bool
    {
        return (int) $number1 === (int) $number2;
    }
}

if (! function_exists('cmprstr')) {
    function cmprstr($string1, $string2): bool
    {
        return mb_strtolower((string) $string1) === mb_strtolower((string) $string2);
    }
}

if (! function_exists('cmprarr')) {
    function cmprarr(array $array1, array $array2): bool
    {
        if (empty(array_diff_assoc($array1, $array2))) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('cmprenum')) {
    function cmprenum($enum1, $enum2): bool
    {
        return $enum1 === $enum2;
    }
}

if (! function_exists('is_positive_num')) {
    function is_positive_num($number): bool
    {
        return is_more($number, 0);
    }
}

if (! function_exists('is_negative_num')) {
    function is_negative_num($number): bool
    {
        return is_more(0, $number);
    }
}

if (! function_exists('is_ean_not_valid')) {
    function is_ean_not_valid($ean): bool
    {
        return empty($ean) || is_more(strlen($ean), 13) || is_more(strlen($ean), 11);
    }
}

if (! function_exists('is_string_valid')) {
    function is_string_valid(?string $string): bool
    {
        return empty(external_code($string)) || is_more(strlen(external_code($string)), 255);
    }
}

if (! function_exists('is_url')) {
    function is_url(string $string): bool
    {
        return str_contains($string, 'www.') || str_contains($string, 'https://') || str_contains($string, 'http://');
    }
}

if (! function_exists('is_max_execution_time_exceeded')) {
    function is_max_execution_time_exceeded($time_start): bool
    {
        return is_more(calc_execution_time($time_start), ini_get('max_execution_time') / 3 * 2);
    }
}

if (! function_exists('is_memory_limit_exceeded')) {
    function is_memory_limit_exceeded(): bool
    {
        return is_more(memory_get_usage(), words2bytes(ini_get('memory_limit')) / 3 * 2);
    }
}

if (! function_exists('is_similar')) {
    function is_similar(float $number1, float $number2, float $max_difference = 0.01): bool
    {
        return is_more_or_equal($max_difference, positive_num($number1 - $number2));
    }
}

if (! function_exists('is_more_or_equal')) {
    function is_more_or_equal($number1, $number2, int $decimals = 2): bool
    {
        return round((float) $number1, $decimals) >= round((float) $number2, $decimals);
    }
}

if (! function_exists('is_more')) {
    function is_more($number1, $number2, int $decimals = 2): bool
    {
        return round((float) $number1, $decimals) > round((float) $number2, $decimals);
    }
}
