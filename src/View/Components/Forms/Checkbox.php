<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Exception;

class Checkbox extends FormComponent
{
    /**
     * @throws Exception
     */
    public function __construct(
        string $type,
        string $name = null,
        string $class = null,
        string $id = null,
        string $checked = null,
        string $title = null,
        bool $disabled = false,
        bool $required = false,
    ) {
        $this->validateType($type);

        parent::__construct(
            name: $name,
            type: $type,
            class: $class,
            id: $id,
            value: $checked,
            title: $title,
            disabled: $disabled,
            required: $required
        );
    }

    private function validateType(string $type): void
    {
        $availableTypes = array_values([self::TYPE_CHECKBOX, self::TYPE_RADIO]);

        if (!isset($availableTypes[$type])) {
            throw new Exception("Checkbox type cannot be '$type'!");
        }
    }
}
