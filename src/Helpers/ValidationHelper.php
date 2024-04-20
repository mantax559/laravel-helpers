<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ValidationHelper
{
    public static function getRequiredRules(string|bool|null $required = null): array
    {
        if (is_string($required)) {
            return [$required, 'nullable'];
        } elseif (is_bool($required) && ! $required) {
            return ['nullable'];
        } else {
            return ['required'];
        }
    }

    public static function getStringRules(string|bool|null $required = null, ?int $max = null, string|array|null $additional = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'string',
            'max:'.($max ?? config('laravel-helpers.validation.max_string_length')),
            $additional,
        );
    }

    public static function getTextRules(string|bool|null $required = null, ?int $max = null, string|array|null $additional = null): array
    {
        return self::getStringRules($required, $max ?? config('laravel-helpers.validation.max_text_length'), $additional);
    }

    public static function getBooleanRules(string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'boolean',
        );
    }

    public static function getAcceptedRules(string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'accepted',
        );
    }

    public static function getNumericRules(string|bool|null $required = null, float $min = 0, ?float $max = null, string|array|null $additional = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'numeric',
            'min:'.$min,
            'max:'.($max ?? config('laravel-helpers.validation.max_number')),
            $additional,
        );
    }

    public static function getIntegerRules(string|bool|null $required = null, int $min = 0, ?int $max = null, string|array|null $additional = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'integer',
            'min:'.$min,
            'max:'.($max ?? config('laravel-helpers.validation.max_number')),
            $additional,
        );
    }

    public static function getDateRules(string|bool|null $required = null, string|array|null $additional = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'date',
            $additional,
        );
    }

    public static function getImageRules(
        string|bool|null $required = null,
        ?int $fileSize = null,
        ?int $minFileSize = null,
        ?int $maxFileSize = null,
        ?int $width = null,
        ?int $height = null,
        ?int $minWidth = null,
        ?int $minHeight = null,
        ?int $maxWidth = null,
        ?int $maxHeight = null,
        ?string $mimes = null
    ): array {
        $fileSizes = [];

        if ($fileSize) {
            $fileSizes[] = "size:$fileSize";
        } else {
            if ($minFileSize) {
                $fileSizes[] = "min:$minFileSize";
            }

            if ($maxFileSize) {
                $fileSizes[] = "max:$maxFileSize";
            } else {
                $fileSizes[] = 'max:'.config('laravel-helpers.validation.max_file_size');
            }
        }

        $dimensions = [];

        if ($width) {
            $dimensions[] = "width=$width";
        } else {
            if ($minWidth) {
                $dimensions[] = "min_width=$minWidth";
            } else {
                $dimensions[] = 'min_width='.config('laravel-helpers.validation.min_image_dimension');
            }

            if ($maxWidth) {
                $dimensions[] = "max_width=$maxWidth";
            }
        }

        if ($height) {
            $dimensions[] = "height=$height";
        } else {
            if ($minHeight) {
                $dimensions[] = "min_height=$minHeight";
            } else {
                $dimensions[] = 'min_height='.config('laravel-helpers.validation.min_image_dimension');
            }

            if ($maxHeight) {
                $dimensions[] = "max_height=$maxHeight";
            }
        }

        $dimensions = 'dimensions:'.implode(',', $dimensions);

        return self::mergeRules(
            self::getRequiredRules($required),
            'image',
            $fileSizes,
            $dimensions,
            'mimes:'.($mimes ?? config('laravel-helpers.validation.accept_image_mimes')),
        );
    }

    public static function getFileRules(
        string|bool|null $required = null,
        ?int $fileSize = null,
        ?int $minFileSize = null,
        ?int $maxFileSize = null,
        ?string $mimes = null
    ): array {
        $fileSizes = [];

        if ($fileSize) {
            $fileSizes[] = "size:$fileSize";
        } else {
            if ($minFileSize) {
                $fileSizes[] = "min:$minFileSize";
            }

            if ($maxFileSize) {
                $fileSizes[] = "max:$maxFileSize";
            } else {
                $fileSizes[] = 'max:'.config('laravel-helpers.validation.max_file_size');
            }
        }

        return self::mergeRules(
            self::getRequiredRules($required),
            'file',
            $fileSizes,
            'mimes:'.($mimes ?? config('laravel-helpers.validation.accept_file_mimes')),
        );
    }

    public static function getArrayRules(int $min = 0, ?int $max = null): array
    {
        return self::mergeRules(
            self::getRequiredRules(is_positive_num($min)),
            'array',
            'min:'.$min,
            'max:'.($max ?? config('laravel-helpers.validation.max_array')),
        );
    }

    public static function getEmailRules(string|bool|null $required = null, bool $validateEmail = true): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'max:'.config('laravel-helpers.validation.max_string_length'),
            $validateEmail ? 'email:rfc,strict,dns,spoof' : 'email',
        );
    }

    public static function getPasswordRules(string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            'confirmed',
            Password::min(config('laravel-helpers.validation.min_password_length'))
                ->max(config('laravel-helpers.validation.max_password_length'))
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
        );
    }

    public static function getUniqueRules(string $table, mixed $ignore = null, string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            empty($ignore) ? Rule::unique($table) : Rule::unique($table)->ignore($ignore),
        );
    }

    public static function getInArrayRules(Collection|array $values, string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            Rule::in($values),
        );
    }

    public static function getModelRules(Builder|Collection|string $model, string|bool|null $required = null): array
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

    public static function getEnumRules(mixed $enum, string|bool|null $required = null): array
    {
        return self::mergeRules(
            self::getRequiredRules($required),
            Rule::in($enum::cases()),
        );
    }

    public static function mergeRules(...$array): array
    {
        $rules = [];

        foreach ($array as $item) {
            if (empty($item) && ! cmprstr($item, 0)) {
                continue;
            }

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
