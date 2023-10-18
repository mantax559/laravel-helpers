<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class ValidationHelper
{
    public static function getRequiredRules(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
        ];
    }

    public static function getStringRules(bool $isRequired = true, int $max = 0): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.(is_positive_num($max) ? $max : config('laravel-helpers.validation.max_string_length')),
        ];
    }

    public static function getTextRules(int $min = 3, int $max = 0): array
    {
        return [
            self::getRequiredRule(is_positive_num($min)),
            'min:'.$min,
            'max:'.(is_positive_num($max) ? $max : config('laravel-helpers.validation.max_text_length')),
        ];
    }

    public static function getBooleanRules(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'boolean',
        ];
    }

    public static function getNumericRules(int $lowestNumber = 0, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'numeric',
            'min:'.$lowestNumber,
        ];
    }

    public static function getIntegerRules(int $lowestNumber = 0, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'integer',
            'min:'.$lowestNumber,
        ];
    }

    public static function getDateRules(bool $isRequired = true, string $after = null): array
    {
        $rule = [
            self::getRequiredRule($isRequired),
            'date',
        ];

        if (! empty($after)) {
            $rule = array_merge([$rule, ['after:'.$after]]);
        }

        return $rule;
    }

    public static function getImageRules(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_extensions'),
        ];
    }

    public static function getFileRules(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.config('laravel-helpers.validation.accept_file_extensions'),
        ];
    }

    public static function getArrayRules(int $minRules = 0, int $maxRules = null): array
    {
        return [
            self::getRequiredRule(is_positive_num($minRules)),
            'array',
            'min:'.$minRules,
            'max:'.($maxRules ?? config('laravel-helpers.validation.max_array')),
        ];
    }

    public static function getInArrayRules(Collection|array $values, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            Rule::in($values),
        ];
    }

    public static function getModelRules(Builder|string $model, bool $isRequired = true): array
    {
        if ($model instanceof Builder) {
            $model = $model->pluck('id');
        } else {
            $model = $model::pluck('id');
        }

        return [
            self::getRequiredRule($isRequired),
            'integer',
            Rule::in($model),
        ];
    }

    public static function getEnumRules($enum, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.config('laravel-helpers.validation.max_string_length'),
            new Enum($enum),
        ];
    }

    public static function getEmailRules(bool $isRequired = true): array
    {
        $rule = [
            self::getRequiredRule($isRequired),
            'email:rfc,dns',
        ];

        return $rule;
    }

    public static function getPasswordRules(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'confirmed',
            Password::min(config('laravel-helpers.validation.min_password_length'))
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
        ];
    }

    public static function getWithValidator(string $attribute, array $fields): ?string
    {
        [$field, $line] = explode('.', $attribute);

        foreach ($fields as $fieldLine => $fieldItem) {
            if (cmprstr($field, $fieldItem)) {
                return ((int) $line + 1).' '.__($fieldLine);
            }
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public static function throwValidationException(string $method): void
    {
        throw new Exception(__('The method ":method" is not described in the validation rules!', ['method' => $method]));
    }

    private static function getRequiredRule(bool $isRequired = true): string
    {
        return $isRequired ? 'required' : 'nullable';
    }
}
