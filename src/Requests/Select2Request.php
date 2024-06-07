<?php

namespace Mantax559\LaravelHelpers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class Select2Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => ValidationHelper::getStringRules(required: false),
            'page' => ValidationHelper::getIntegerRules(required: false),
            'values' => ValidationHelper::getStringRules(required: false),
        ];
    }
}
