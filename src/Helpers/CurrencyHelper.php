<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class CurrencyHelper
{
    public const API_URL = 'https://api.frankfurter.app/';

    public const EUR_CURRENCY_CODE = 'EUR';

    public static function convertToEur(string $fromCurrency, ?float $amount, Carbon|string|null $date = null, int $round = 2): float
    {
        return self::convertCurrency($fromCurrency, self::EUR_CURRENCY_CODE, $amount, $date, $round);
    }

    public static function convertFromEur(string $toCurrency, ?float $amount, Carbon|string|null $date = null, int $round = 2): float
    {
        return self::convertCurrency(self::EUR_CURRENCY_CODE, $toCurrency, $amount, $date, $round);
    }

    public static function convertCurrency(string $fromCurrency, string $toCurrency, ?float $amount, Carbon|string|null $date = null, int $round = 2): float
    {
        if (empty($amount) || ! is_positive_num($amount)) {
            return 0;
        }

        if (cmprstr($fromCurrency, $toCurrency)) {
            return round($amount, $round);
        }

        $rates = self::getCurrencies($date);

        if (! isset($rates[$fromCurrency]) && ! cmprstr($fromCurrency, self::EUR_CURRENCY_CODE)) {
            throw new InvalidArgumentException("The currency '$fromCurrency' does not exist.");
        } elseif (! isset($rates[$toCurrency]) && ! cmprstr($toCurrency, self::EUR_CURRENCY_CODE)) {
            throw new InvalidArgumentException("The currency '$toCurrency' does not exist.");
        }

        $amountInEur = cmprstr($fromCurrency, self::EUR_CURRENCY_CODE) ? $amount : $amount / $rates[$fromCurrency];
        $amountInEur = cmprstr($toCurrency, self::EUR_CURRENCY_CODE) ? $amountInEur : $amountInEur * $rates[$toCurrency];

        return round($amountInEur, $round);
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

            $response = $client->request('GET', self::API_URL.$date);

            if (! cmprint($response->getStatusCode(), 200)) {
                throw new Exception("Unable to fetch currency rates for date: {$date}.");
            }

            $body = json_decode($response->getBody()->getContents(), true);

            if (! cmprint($body['amount'], 1)) {
                throw new Exception('Expected the amount to be 1 as a base for conversion rates, but received a different value: '.$body['amount']);
            } elseif (! cmprstr($body['base'], 'EUR')) {
                throw new Exception('Expected the base currency to be EUR, but received: '.$body['base']);
            }

            return $body['rates'] ?? [];
        });
    }
}
