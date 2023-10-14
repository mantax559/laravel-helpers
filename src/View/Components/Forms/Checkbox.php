<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Exception;

class Checkbox extends FormComponent
{
    /**
     * @throws Exception
     */
    public function __construct(
        string $name,
        string $type = null,
        string $class = null,
        string $id = null,
        string $value = null,
        string $title = null,
        bool $disabled = false,
        bool $required = false,
        public string|array|null $checked = null,
    ) {
        $type = $type ?? self::TYPE_CHECKBOX;

        $this->validateType($type);

        parent::__construct(
            name: $name,
            type: $type,
            class: $class,
            id: $id,
            value: $value,
            title: $title,
            checked: $checked,
            disabled: $disabled,
            required: $required,
        );
    }

    private function validateType(string $type): void
    {
        $availableTypes = array_flip([self::TYPE_CHECKBOX, self::TYPE_RADIO]);

        if (!isset($availableTypes[$type])) {
            throw new Exception("Checkbox type cannot be '$type'!");
        }
    }
}
