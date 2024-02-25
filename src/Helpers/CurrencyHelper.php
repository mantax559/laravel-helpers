<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyHelper
{
    private const API_URL = 'https://api.frankfurter.app/';

    public function convertToEur(string $fromCurrency, ?float $amount, string $date): float
    {
        return $this->convertCurrency($fromCurrency, 'EUR', $amount, $date);
    }

    public function convertFromEur(string $toCurrency, ?float $amount, string $date): float
    {
        return $this->convertCurrency('EUR', $toCurrency, $amount, $date);
    }

    private function getCurrencies(string $date): array
    {
        $cacheKey = 'currency_rates_' . Carbon::parse($date)->format('Y-m-d');
        return Cache::rememberForever($cacheKey, function () use ($date) {
            $response = Http::get(self::API_URL . $date);
            if ($response->successful()) {
                return $response->json('rates');
            }

            throw new Exception("Unable to fetch currency rates for date: {$date}.");
        });
    }

    private function convertCurrency(string $fromCurrency, string $toCurrency, ?float $amount, string $date): float
    {
        if (empty($amount)) {
            return 0;
        }

        $rates = $this->getCurrencies($date);

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
}
