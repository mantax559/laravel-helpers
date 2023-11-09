<?php

namespace Mantax559\LaravelHelpers\Test\Unit;

use Mantax559\LaravelHelpers\Helpers\ValidationHelper;
use Orchestra\Testbench\TestCase;

class ValidationHelperTest extends TestCase
{
    private string $requiredCondition;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'laravel-helpers.validation.max_string_length' => 255,
            'laravel-helpers.validation.min_text_length' => 3,
            'laravel-helpers.validation.max_text_length' => 1000,
            'laravel-helpers.validation.max_array' => 100,
            'laravel-helpers.validation.max_file_size' => 4096,
            'laravel-helpers.validation.min_image_dimension' => 200,
            'laravel-helpers.validation.min_password_length' => 18,
            'laravel-helpers.validation.accept_image_extensions' => 'png',
            'laravel-helpers.validation.accept_file_extensions' => 'pdf',
        ]);

        $this->requiredCondition = 'required_if:is_active,false';
    }

    public function test_get_required_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
        ], ValidationHelper::getRequiredRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
        ], ValidationHelper::getRequiredRules(false));

        $this->assertEquals([
            'required',
        ], ValidationHelper::getRequiredRules(true));
    }

    public function test_get_string_rules()
    {
        $this->assertEquals([
            'required',
            'max:' . config('laravel-helpers.validation.max_string_length'),
        ], ValidationHelper::getStringRules(true));

        $this->assertEquals([
            'required',
            'max:15',
        ], ValidationHelper::getStringRules(true, 15));

        $this->assertEquals([
            'nullable',
            'max:17',
        ], ValidationHelper::getStringRules(false, 17));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'max:9999999',
        ], ValidationHelper::getStringRules($this->requiredCondition, 9999999));
    }

    public function test_get_text_rules()
    {
        $this->assertEquals([
            'required',
            'min:' . config('laravel-helpers.validation.min_text_length'),
            'max:' . config('laravel-helpers.validation.max_text_length'),
        ], ValidationHelper::getTextRules());

        $this->assertEquals([
            'required',
            'min:3',
            'max:5',
        ], ValidationHelper::getTextRules(3, 5));
    }

    public function test_get_boolean_rules()
    {
        $this->assertEquals([
            'required',
            'boolean',
        ], ValidationHelper::getBooleanRules(true));

        $this->assertEquals([
            'nullable',
            'boolean',
        ], ValidationHelper::getBooleanRules(false));
    }

    public function test_get_numeric_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'numeric',
            'min:0',
        ], ValidationHelper::getNumericRules(0, $this->requiredCondition));

        $this->assertEquals([
            'required',
            'numeric',
            'min:0',
        ], ValidationHelper::getNumericRules(0, true));

        $this->assertEquals([
            'required',
            'numeric',
            'min:15',
        ], ValidationHelper::getNumericRules(15, true));

        $this->assertEquals([
            'nullable',
            'numeric',
            'min:15',
        ], ValidationHelper::getNumericRules(15, false));
    }
}
