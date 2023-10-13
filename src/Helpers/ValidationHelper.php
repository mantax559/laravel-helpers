<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ValidationHelper
{
    private const MAX_STRING_LENGTH = 255;

    private const MAX_TEXT_LENGTH = 1000;

    private const MAX_ARRAY = 100;

    private const MAX_FILE_SIZE = 4096;

    private const MIN_IMAGE_DIMENSION = 200;

    private const ACCEPT_IMAGE_EXTENSIONS = 'apng,avif,gif,jpg,jpeg,jfif,pjpeg,pjp,png,svg,webp';

    private const ACCEPT_FILE_EXTENSIONS = 'pdf';

    public static function getMultipleRules(array $rules): array
    {
        return array_merge($rules);
    }

    public static function getRequiredRule(bool $isRequired = true): array
    {
        return [
            $isRequired ? 'required' : 'nullable',
        ];
    }

    public static function getStringRule(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.self::MAX_STRING_LENGTH,
        ];
    }

    public static function getTextRule(int $min = 0, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'min:'.$min,
            'max:'.self::MAX_TEXT_LENGTH,
        ];
    }

    public static function getBooleanRule(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'boolean',
        ];
    }

    public static function getNumericRule(int $lowestNumber = 0, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'numeric',
            'min:'.$lowestNumber,
        ];
    }

    public static function getIntegerRule(int $lowestNumber = 0, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'integer',
            'min:'.$lowestNumber,
        ];
    }

    public static function getDateRule(bool $isRequired = true, string $after = null): array
    {
        $rules = [
            self::getRequiredRule($isRequired),
            'date',
        ];

        if (! empty($after)) {
            $rules = array_merge($rules, ['after:'.$after]);
        }

        return $rules;
    }

    public static function getImageRule(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'image',
            'max:'.self::MAX_FILE_SIZE,
            'dimensions:min_width='.self::MIN_IMAGE_DIMENSION.',min_height='.self::MIN_IMAGE_DIMENSION,
            'mimes:'.self::ACCEPT_IMAGE_EXTENSIONS,
        ];
    }

    public static function getFileRule(bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.self::MAX_FILE_SIZE,
            'mimes:'.self::ACCEPT_FILE_EXTENSIONS,
        ];
    }

    public static function getArrayRule(int $minRules = 0, int $maxRules = null): array
    {
        return [
            self::getRequiredRule(is_more($minRules, 0)),
            'array',
            'min:'.$minRules,
            'max:'.($maxRules ?? self::MAX_ARRAY),
        ];
    }

    public static function getInArrayRule(Collection|array $values, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            Rule::in($values),
        ];
    }

    public static function getModelRule(Builder|string $model, bool $isRequired = true): array
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

    public static function getEnumRule($enum, bool $isRequired = true): array
    {
        return [
            self::getRequiredRule($isRequired),
            'max:'.self::MAX_STRING_LENGTH,
            new Enum($enum),
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
}
