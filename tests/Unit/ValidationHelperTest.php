<?php

namespace Mantax559\LaravelHelpers\Test\Unit;

use Mantax559\LaravelHelpers\Helpers\ValidationHelper;
use Orchestra\Testbench\TestCase;

class ValidationHelperTest extends TestCase
{
    private string $requiredCondition;
    private string $dateCondition;

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
        $this->dateCondition = 'after_or_equal:due_date';
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
        ], ValidationHelper::getIntegerRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'integer',
            'min:0',
        ], ValidationHelper::getIntegerRules(false));

        $this->assertEquals([
            'required',
            'integer',
            'min:0',
        ], ValidationHelper::getIntegerRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'integer',
            'min:15',
        ], ValidationHelper::getIntegerRules($this->requiredCondition, 15));

        $this->assertEquals([
            'nullable',
            'integer',
            'min:15',
        ], ValidationHelper::getIntegerRules(false, 15));

        $this->assertEquals([
            'required',
            'integer',
            'min:15',
        ], ValidationHelper::getIntegerRules(true, 15));
    }

    public function test_get_date_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'date',
        ], ValidationHelper::getDateRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'date',
        ], ValidationHelper::getDateRules(false));

        $this->assertEquals([
            'required',
            'date',
        ], ValidationHelper::getDateRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'date',
            $this->dateCondition,
        ], ValidationHelper::getDateRules($this->requiredCondition, $this->dateCondition));

        $this->assertEquals([
            'nullable',
            'date',
            $this->dateCondition,
        ], ValidationHelper::getDateRules(false, $this->dateCondition));

        $this->assertEquals([
            'required',
            'date',
            $this->dateCondition,
        ], ValidationHelper::getDateRules(true, $this->dateCondition));
    }

    public function test_get_image_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_extensions'),
        ], ValidationHelper::getImageRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_extensions'),
        ], ValidationHelper::getImageRules(false));

        $this->assertEquals([
            'required',
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_extensions'),
        ], ValidationHelper::getImageRules(true));
    }

    public function test_get_file_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.config('laravel-helpers.validation.accept_file_extensions'),
        ], ValidationHelper::getFileRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.config('laravel-helpers.validation.accept_file_extensions'),
        ], ValidationHelper::getFileRules(false));

        $this->assertEquals([
            'required',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.config('laravel-helpers.validation.accept_file_extensions'),
        ], ValidationHelper::getFileRules(true));

        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:xlsx',
        ], ValidationHelper::getFileRules($this->requiredCondition, 'xlsx'));

        $this->assertEquals([
            'nullable',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:xlsx',
        ], ValidationHelper::getFileRules(false, 'xlsx'));

        $this->assertEquals([
            'required',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:xlsx',
        ], ValidationHelper::getFileRules(true, 'xlsx'));
    }

    public function test_get_array_rules()
    {
        $this->assertEquals([
            'nullable',
            'array',
            'min:0',
            'max:' . config('laravel-helpers.validation.max_array'),
        ], ValidationHelper::getArrayRules());

        $this->assertEquals([
            'nullable',
            'array',
            'min:0',
            'max:' . config('laravel-helpers.validation.max_array'),
        ], ValidationHelper::getArrayRules());

        $this->assertEquals([
            'required',
            'array',
            'min:4',
            'max:8',
        ], ValidationHelper::getArrayRules(4, 8));

        $this->assertEquals([
            'required',
            'array',
            'min:4',
            'max:8',
        ], ValidationHelper::getArrayRules(4, 8));
    }

    public function test_get_email_rules()
    {
        $this->assertEquals([
            $this->requiredCondition,
            'nullable',
            'email:rfc,dns',
        ], ValidationHelper::getEmailRules($this->requiredCondition));

        $this->assertEquals([
            'nullable',
            'email:rfc,dns',
        ], ValidationHelper::getEmailRules(false));

        $this->assertEquals([
            'required',
            'email:rfc,dns',
        ], ValidationHelper::getEmailRules(true));
    }
}
