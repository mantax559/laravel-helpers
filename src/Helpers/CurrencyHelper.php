<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyHelper
{
    private const API_URL = 'https://api.frankfurter.app/';

    public static function convertToEur(string $fromCurrency, ?float $amount, string $date): float
    {
        return self::convertCurrency($fromCurrency, 'EUR', $amount, $date);
    }

    public static function convertFromEur(string $toCurrency, ?float $amount, string $date): float
    {
        return self::convertCurrency('EUR', $toCurrency, $amount, $date);
    }

    private static function convertCurrency(string $fromCurrency, string $toCurrency, ?float $amount, string $date): float
    {
        if (empty($amount)) {
            return 0;
        }

        $rates = self::getCurrencies($date);

        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        if ($fromCurrency !== 'EUR' && isset($rates[$fromCurrency])) {
            return $amount / $rates[$fromCurrency];
        }

        if ($toCurrency !== 'EUR' && isset($rates[$toCurrency])) {
            return $amount * $rates[$toCurrency];
        }

        throw new Exception("The currency '{$fromCurrency}' or '{$toCurrency}' does not exist.");
    }

    private static function getCurrencies(string $date): array
    {
        $date = Carbon::parse($date)->format('Y-m-d');
        $cacheKey = 'currency_rates_'.$date;

        return Cache::rememberForever($cacheKey, function () use ($date) {
            $response = Http::get(self::API_URL.$date);
            if ($response->successful()) {
                return $response->json('rates');
            }

            throw new Exception("Unable to fetch currency rates for date: {$date}.");
        });
    }
}
