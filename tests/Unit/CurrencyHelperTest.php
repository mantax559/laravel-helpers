<?php

namespace Mantax559\LaravelHelpers\Test\Unit;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Mantax559\LaravelHelpers\Helpers\CurrencyHelper;
use Orchestra\Testbench\TestCase;

class CurrencyHelperTest extends TestCase
{
    private string $date;

    protected function setUp(): void
    {
        parent::setUp();

        $this->date = '2010-05-11';
    }

    public function test_convert_to_eur()
    {
        $this->assertEquals(0, CurrencyHelper::convertToEur('EEK', null, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertToEur('EEK', -10, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertToEur('EEK', 0, $this->date));
        $this->assertEquals(0.06, CurrencyHelper::convertToEur('EEK', 1, $this->date));
        $this->assertEquals(0.58, CurrencyHelper::convertToEur('EEK', 9, $this->date));
        $this->assertEquals(3.71, CurrencyHelper::convertToEur('EEK', 58, $this->date));
    }

    public function test_convert_from_eur()
    {
        $this->assertEquals(0, CurrencyHelper::convertToEur('EEK', null, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertFromEur('EEK', -10, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertFromEur('EEK', 0, $this->date));
        $this->assertEquals(15.65, CurrencyHelper::convertFromEur('EEK', 1, $this->date));
        $this->assertEquals(140.82, CurrencyHelper::convertFromEur('EEK', 9, $this->date));
        $this->assertEquals(907.5, CurrencyHelper::convertFromEur('EEK', 58, $this->date));
    }

    public function test_convert_currency()
    {
        $this->assertEquals(2.84, CurrencyHelper::convertCurrency('CZK', 'HRK', 10, $this->date));
        $this->assertEquals(12.7, CurrencyHelper::convertCurrency('EUR', 'USD', 10, $this->date));
        $this->assertEquals(6.77, CurrencyHelper::convertCurrency('USD', 'GBP', 10, $this->date));
        $this->assertEquals(404.91, CurrencyHelper::convertCurrency('AUD', 'INR', 10, $this->date));
        $this->assertEquals(10, CurrencyHelper::convertCurrency('USD', 'USD', 10, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertCurrency('EUR', 'JPY', 0, $this->date));
        $this->assertEquals(0, CurrencyHelper::convertCurrency('EUR', 'JPY', null, $this->date));
    }

    public function test_invalid_currency()
    {
        $this->expectException(InvalidArgumentException::class);
        CurrencyHelper::convertCurrency('XXX', 'YYY', 100, $this->date);
    }

    public function test_currency_api_response()
    {
        $client = new Client();
        $response = $client->request('GET', CurrencyHelper::API_URL.$this->date);

        $data = json_decode($response->getBody(), true);

        $this->assertEquals('1.0', $data['amount']);
        $this->assertEquals('EUR', $data['base']);
        $this->assertEquals('2010-05-11', $data['date']);
        $this->assertArrayHasKey('rates', $data);
        $this->assertArrayHasKey('USD', $data['rates']);
        $this->assertEquals(1.2698, $data['rates']['USD']);
    }
}
