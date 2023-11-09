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
    public static function getRequiredRules(string|bool $required = null): array
    {
        if (is_string($required)) {
            return [$required, 'nullable'];
        } elseif (is_bool($required) && ! $required) {
            return ['nullable'];
        } else {
            return ['required'];
        }
    }

    public static function getStringRules(string|bool $required = null, int $max = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'max:'.($max ?? config('laravel-helpers.validation.max_string_length')),
        );
    }

    public static function getTextRules(int $min = null, int $max = null): array
    {
        $min = $min ?? config('laravel-helpers.validation.min_text_length');

        return self::mergeRules(
            self::getRequiredRules(is_positive_num($min)),
            'min:'.$min,
            'max:'.($max ?? config('laravel-helpers.validation.max_text_length')),
        );
    }

    public static function getBooleanRules(string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'boolean',
        );
    }

    public static function getNumericRules(int $lowestNumber = 0, string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'numeric',
            'min:'.$lowestNumber,
        );
    }

    public static function getIntegerRules(int $lowestNumber = 0, string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'integer',
            'min:'.$lowestNumber,
        );
    }

    public static function getDateRules(string|bool $required = null, string $after = null): array
    {
        $rule = self::mergeRules(
            self::getRequiredRules($required),
            'date',
        );

        if (! empty($after)) {
            $rule = self::mergeRules($rule, $after);
        }

        return $rule;
    }

    public static function getImageRules(string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'image',
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'dimensions:min_width='.config('laravel-helpers.validation.min_image_dimension').',min_height='.config('laravel-helpers.validation.min_image_dimension'),
            'mimes:'.config('laravel-helpers.validation.accept_image_extensions'),
        );
    }

    public static function getFileRules(string|bool $required = null, string $extensions = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'max:'.config('laravel-helpers.validation.max_file_size'),
            'mimes:'.($extensions ?? config('laravel-helpers.validation.accept_file_extensions')),
        );
    }

    public static function getArrayRules(int $minRules = 0, int $maxRules = null): array
    {
        return self::mergeRules(
            self::getRequiredRules(is_positive_num($minRules)),
            'array',
            'min:'.$minRules,
            'max:'.($maxRules ?? config('laravel-helpers.validation.max_array')),
        );
    }

    public static function getInArrayRules(Collection|array $values, string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            Rule::in($values),
        );
    }

    public static function getModelRules(Builder|string $model, string|bool $required = null): array
    {
        if ($model instanceof Builder) {
            $model = $model->pluck('id');
        } else {
            $model = $model::pluck('id');
        }

        return self::mergeRules(
            self::getRequiredRules($required),
            'integer',
            Rule::in($model),
        );
    }

    public static function getEnumRules($enum, string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'max:'.config('laravel-helpers.validation.max_string_length'),
            new Enum($enum),
        );
    }

    public static function getEmailRules(string|bool $required = null): array
    {
        $rule = self::mergeRules(
            self::getRequiredRules($required),
            'email:rfc,dns',
        );

        return $rule;
    }

    public static function getPasswordRules(string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'confirmed',
            Password::min(config('laravel-helpers.validation.min_password_length'))
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
        );
    }

    public static function getUniqueRules(string $table, mixed $ignore, string|bool $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            Rule::unique($table)->ignore($ignore),
        );
    }

    public static function mergeRules(...$array): array
    {
        $rules = [];

        foreach ($array as $item) {
            if (! is_array($item)) {
                $item = [$item];
            }

            $rules = array_merge($rules, $item);
        }

        return array_values(array_unique($rules));
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
}
