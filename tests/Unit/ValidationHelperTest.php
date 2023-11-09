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
            $this->requiredCondition,
            'nullable',
            'max:' . config('laravel-helpers.validation.max_string_length'),
        ], ValidationHelper::getStringRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'max:' . config('laravel-helpers.validation.max_string_length'),
        ], ValidationHelper::getStringRules(false));

        $this->assertEquals([
            'required',
            'max:' . config('laravel-helpers.validation.max_string_length'),
        ], ValidationHelper::getStringRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'max:15',
        ], ValidationHelper::getStringRules($this->requiredCondition, 15));

        $this->assertEquals([
            'nullable',
            'max:15',
        ], ValidationHelper::getStringRules(false, 15));

        $this->assertEquals([
            'required',
            'max:15',
        ], ValidationHelper::getStringRules(true, 15));
    }

    public function test_get_text_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'min:' . config('laravel-helpers.validation.min_text_length'),
            'max:' . config('laravel-helpers.validation.max_text_length'),
        ], ValidationHelper::getTextRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'min:' . config('laravel-helpers.validation.min_text_length'),
            'max:' . config('laravel-helpers.validation.max_text_length'),
        ], ValidationHelper::getTextRules(false));

        $this->assertEquals([
            'required',
            'min:' . config('laravel-helpers.validation.min_text_length'),
            'max:' . config('laravel-helpers.validation.max_text_length'),
        ], ValidationHelper::getTextRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'min:7',
            'max:9',
        ], ValidationHelper::getTextRules($this->requiredCondition, 7, 9));

        $this->assertEquals([
            'nullable',
            'min:7',
            'max:9',
        ], ValidationHelper::getTextRules(false, 7, 9));

        $this->assertEquals([
            'required',
            'min:7',
            'max:9',
        ], ValidationHelper::getTextRules(true, 7, 9));
    }

    public function test_get_boolean_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'boolean',
        ], ValidationHelper::getBooleanRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'boolean',
        ], ValidationHelper::getBooleanRules(false));

        $this->assertEquals([
            'required',
            'boolean',
        ], ValidationHelper::getBooleanRules(true));
    }

    public function test_get_numeric_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'numeric',
            'min:0',
        ], ValidationHelper::getNumericRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'numeric',
            'min:0',
        ], ValidationHelper::getNumericRules(false));

        $this->assertEquals([
            'required',
            'numeric',
            'min:0',
        ], ValidationHelper::getNumericRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'numeric',
            'min:15',
        ], ValidationHelper::getNumericRules($this->requiredCondition, 15));

        $this->assertEquals([
            'nullable',
            'numeric',
            'min:15',
        ], ValidationHelper::getNumericRules(false, 15));

        $this->assertEquals([
            'required',
            'numeric',
            'min:15',
        ], ValidationHelper::getNumericRules(true, 15));
    }

    public function test_get_integer_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'integer',
            'min:0',
        ], ValidationHelper::getNumericRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'integer',
            'min:0',
        ], ValidationHelper::getNumericRules(false));

        $this->assertEquals([
            'required',
            'integer',
            'min:0',
        ], ValidationHelper::getNumericRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'integer',
            'min:15',
        ], ValidationHelper::getNumericRules($this->requiredCondition, 15));

        $this->assertEquals([
            'nullable',
            'integer',
            'min:15',
        ], ValidationHelper::getNumericRules(false, 15));

        $this->assertEquals([
            'required',
            'integer',
            'min:15',
        ], ValidationHelper::getNumericRules(true, 15));
    }
}
