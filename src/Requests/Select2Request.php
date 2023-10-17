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
            'query' => ValidationHelper::getStringRules(false),
            'page' => ValidationHelper::getIntegerRules(0, false),
            'values' => ValidationHelper::getStringRules(false),
        ];
    }
}
