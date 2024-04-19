<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyHelper
{
    private const API_URL = 'https://api.frankfurter.app/';

    private const EUR_CURRENCY_CODE = 'EUR';

    public static function convertToEur(string $fromCurrency, ?float $amount, Carbon|string|null $date = null): float
    {
        return self::convertCurrency($fromCurrency, self::EUR_CURRENCY_CODE, $amount, $date);
    }

    public static function convertFromEur(string $toCurrency, ?float $amount, Carbon|string|null $date = null): float
    {
        return self::convertCurrency(self::EUR_CURRENCY_CODE, $toCurrency, $amount, $date);
    }

    public static function convertCurrency(string $fromCurrency, string $toCurrency, ?float $amount, Carbon|string|null $date = null): float
    {
        if (empty($amount)) {
            return 0;
        }

        $rates = self::getCurrencies($date);

        if (cmprstr($fromCurrency, $toCurrency)) {
            return $amount;
        }

        if (! cmprstr($fromCurrency, self::EUR_CURRENCY_CODE) && isset($rates[$fromCurrency])) {
            return $amount / $rates[$fromCurrency];
        }

        if (! cmprstr($toCurrency, self::EUR_CURRENCY_CODE) && isset($rates[$toCurrency])) {
            return $amount * $rates[$toCurrency];
        }

        throw new Exception("The currency '{$fromCurrency}' or '{$toCurrency}' does not exist.");
    }

    private static function getCurrencies(Carbon|string|null $date): array
    {
        if (empty($date)) {
            $date = now()->toDateString();
        } elseif ($date instanceof Carbon) {
            $date = $date->toDateString();
        } else {
            $date = Carbon::parse($date)->format('Y-m-d');
        }

        $cacheKey = 'currency_rates_'.$date;

        return Cache::rememberForever($cacheKey, function () use ($date) {
            $client = new Client();
            $response = $client->request('GET', self::API_URL . $date);
            if (cmprint($response->getStatusCode(), 200)) {
                $body = json_decode($response->getBody()->getContents(), true);
                return $body['rates'] ?? [];
            }

            throw new Exception("Unable to fetch currency rates for date: {$date}.");
        });
    }
}
