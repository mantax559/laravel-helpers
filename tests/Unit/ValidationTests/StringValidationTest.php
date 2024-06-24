<?php

namespace Mantax559\LaravelHelpers\Test\Unit;

use Illuminate\Support\Facades\Validator;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;
use Orchestra\Testbench\TestCase;

class StringValidationTest extends TestCase // TODO: Write all tests
{
    public function stringProvider(): array
    {
        return [
            ['null', false],
            ['', false],
            [' ', true],
            ['valid string', true],
            ['123456', true],
            ['string with special characters !@#$%^&*()', true],
            ['123', true],
            ['true', true],
            ['false', true],
            ['{"key": "value"}', true],
            ['[1, 2, 3]', true],
            ['<html><body>test</body></html>', true],
            ["\n", true],
            ["\t", true],
        ];
    }

    /**
     * @dataProvider stringProvider
     */
    public function testStringValidation(mixed $value, bool $expected): void
    {
        $rules = [
            'column' => ValidationHelper::getStringRules(),
        ];

        $validator = Validator::make(['column' => $value], $rules);
        $this->assertEquals($expected, $validator->passes());
    }
}
