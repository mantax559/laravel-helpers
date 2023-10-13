<?php

namespace Mantax559\LaravelHelpers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class Select2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => ValidationHelper::getStringRule(false),
            'page' => ValidationHelper::getIntegerRule(0, false),
            'values' => ValidationHelper::getStringRule(false),
        ];
    }
}
