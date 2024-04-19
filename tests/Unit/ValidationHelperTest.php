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
            'laravel-helpers.validation.max_text_length' => 1000000,
            'laravel-helpers.validation.max_array' => 100,
            'laravel-helpers.validation.max_file_size' => 4096,
            'laravel-helpers.validation.max_number' => 9223372036854775807,
            'laravel-helpers.validation.max_password_length' => 100,
            'laravel-helpers.validation.min_image_dimension' => 200,
            'laravel-helpers.validation.min_password_length' => 18,
            'laravel-helpers.validation.accept_image_mimes' => 'png',
            'laravel-helpers.validation.accept_file_mimes' => 'pdf',
        ]);

        $this->requiredCondition = 'required_if:is_active,false';
    }

    public function test_get_required_rules()
    {
        $this->assertEquals([
            'required',
        ], ValidationHelper::getRequiredRules());

        $this->assertEquals([
            'nullable',
        ], ValidationHelper::getRequiredRules(required: false));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
        ], ValidationHelper::getRequiredRules(required: $this->requiredCondition));
    }

    public function test_get_string_rules()
    {
        $this->assertEquals([
            'required',
            'string',
            'max:'.config('laravel-helpers.validation.max_string_length'),
        ], ValidationHelper::getStringRules());

        $this->assertEquals([
            'required',
            'string',
            'max:15',
            'alpha',
        ], ValidationHelper::getStringRules(max: 15.999, additional: 'alpha'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'string',
            'max:15',
            'alpha',
            'starts_with:foo,bar',
        ], ValidationHelper::getStringRules(required: $this->requiredCondition, max: 15.999, additional: ['alpha', 'starts_with:foo,bar']));
    }

    public function test_get_text_rules()
    {
        $this->assertEquals([
            'required',
            'string',
            'max:'.config('laravel-helpers.validation.max_text_length'),
        ], ValidationHelper::getTextRules());

        $this->assertEquals([
            'required',
            'string',
            'max:15',
            'alpha',
        ], ValidationHelper::getTextRules(max: 15.999, additional: 'alpha'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'string',
            'max:15',
            'alpha',
            'starts_with:foo,bar',
        ], ValidationHelper::getTextRules(required: $this->requiredCondition, max: 15.999, additional: ['alpha', 'starts_with:foo,bar']));
    }

    public function test_get_boolean_rules()
    {
        $this->assertEquals([
            'required',
            'boolean',
        ], ValidationHelper::getBooleanRules());

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'boolean',
        ], ValidationHelper::getBooleanRules(required: $this->requiredCondition));
    }

    public function test_get_accepted_rules()
    {
        $this->assertEquals([
            'required',
            'accepted',
        ], ValidationHelper::getAcceptedRules());

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'accepted',
        ], ValidationHelper::getAcceptedRules(required: $this->requiredCondition));
    }

    public function test_get_numeric_rules()
    {
        $this->assertEquals([
            'required',
            'numeric',
            'min:0',
            'max:'.config('laravel-helpers.validation.max_number'),
        ], ValidationHelper::getNumericRules());

        $this->assertEquals([
            'required',
            'numeric',
            'min:15.001',
            'max:20.999',
            'in:foo,bar',
        ], ValidationHelper::getNumericRules(min: 15.001, max: 20.999, additional: 'in:foo,bar'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'numeric',
            'min:15.001',
            'max:20.999',
            'in:foo,bar',
            'not_in:foo,bar',
        ], ValidationHelper::getNumericRules(required: $this->requiredCondition, min: 15.001, max: 20.999, additional: ['in:foo,bar', 'not_in:foo,bar']));
    }

    public function test_get_integer_rules()
    {
        $this->assertEquals([
            'required',
            'integer',
            'min:0',
            'max:'.config('laravel-helpers.validation.max_number'),
        ], ValidationHelper::getIntegerRules());

        $this->assertEquals([
            'required',
            'integer',
            'min:15',
            'max:20',
            'in:foo,bar',
        ], ValidationHelper::getIntegerRules(min: 15.001, max: 20.999, additional: 'in:foo,bar'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'integer',
            'min:15',
            'max:20',
            'in:foo,bar',
            'not_in:foo,bar',
        ], ValidationHelper::getIntegerRules(required: $this->requiredCondition, min: 15.001, max: 20.999, additional: ['in:foo,bar', 'not_in:foo,bar']));
    }

    public function test_get_date_rules()
    {
        $this->assertEquals([
            'required',
            'date',
        ], ValidationHelper::getDateRules());

        $this->assertEquals([
            'required',
            'date',
            'after:date',
        ], ValidationHelper::getDateRules(additional: 'after:date'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'date',
            'after:date',
            'before:date',
        ], ValidationHelper::getDateRules(required: $this->requiredCondition, additional: ['after:date', 'before:date']));
    }

    public function test_get_image_rules()
    {
        $this->assertEquals([
            'required',
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_mimes'),
        ], ValidationHelper::getImageRules());

        $this->assertEquals([
            'required',
            'image',
            'size:1024',
            'dimensions:width=1000,min_height=50,max_height=100',
            'mimes:jpg,png',
        ], ValidationHelper::getImageRules(fileSize: '1024', maxFileSize: '2048', width: '1000', minHeight: '50', maxWidth: '2000', maxHeight: '100', mimes: 'jpg,png'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'image',
            'min:1024',
            'max:2048',
            'dimensions:min_width=50,max_width=100,min_height=70,max_height=120',
            'mimes:jpg,png',
        ], ValidationHelper::getImageRules(required: $this->requiredCondition, minFileSize: '1024', maxFileSize: '2048', minWidth: '50', minHeight: '70', maxWidth: '100', maxHeight: '120', mimes: 'jpg,png'));
    }

    public function test_get_file_rules()
    {
        $this->assertEquals([
            'required',
            'file',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.config('laravel-helpers.validation.accept_file_mimes'),
        ], ValidationHelper::getFileRules());

        $this->assertEquals([
            'required',
            'file',
            'size:1024',
            'mimes:xlsx,xls',
        ], ValidationHelper::getFileRules(fileSize: '1024', maxFileSize: '2048', mimes: 'xlsx,xls'));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'file',
            'min:1024',
            'max:2048',
            'mimes:xlsx,xls',
        ], ValidationHelper::getFileRules(required: $this->requiredCondition, minFileSize: '1024', maxFileSize: '2048', mimes: 'xlsx,xls'));
    }

    public function test_get_array_rules()
    {
        $this->assertEquals([
            'nullable',
            'array',
            'min:0',
            'max:'.config('laravel-helpers.validation.max_array'),
        ], ValidationHelper::getArrayRules());

        $this->assertEquals([
            'required',
            'array',
            'min:4',
            'max:8',
        ], ValidationHelper::getArrayRules(min: 4.001, max: 8.999));
    }

    public function test_get_email_rules()
    {
        $this->assertEquals([
            'required',
            'email:rfc,strict,dns,spoof',
        ], ValidationHelper::getEmailRules());

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'email',
        ], ValidationHelper::getEmailRules(required: $this->requiredCondition, validateEmail: false));
    }

    public function test_get_password_rules()
    {
        // TODO: Create logic
    }

    public function test_get_unique_rules()
    {
        // TODO: Create logic
    }

    public function test_get_in_array_rules()
    {
        // TODO: Create logic
    }

    public function test_get_model_rules()
    {
        // TODO: Create logic
    }

    public function test_get_enum_rules()
    {
        // TODO: Create logic
    }

    public function test_merge_rules()
    {
        $this->assertEquals([
            'example1',
            'example2',
            'example3',
        ], ValidationHelper::mergeRules(['example1', 'example2'], 'example3', ['example2'], 'example1'));
    }

    public function test_get_with_validator()
    {
        // TODO: Create logic
    }
}
