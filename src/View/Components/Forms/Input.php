<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Exception;

class Input extends FormComponent
{
    /**
     * @throws Exception
     */
    public function __construct(
        string $name,
        ?string $type = null,
        ?string $class = null,
        ?string $id = null,
        ?string $value = null,
        ?string $title = null,
        ?string $placeholder = null,
        ?string $tooltip = null,
        ?string $append = null,
        ?string $accept = null,
        bool $autocomplete = false,
        bool $autofocus = false,
        bool $disabled = false,
        bool $required = false,
        public ?string $label = null,
        public ?string $wireModel = null,
        public ?string $wireModelDefer = null,
        public ?string $wireKeydownEnter = null,
    ) {
        $type = $type ?? self::TYPE_TEXT;

        $this->validateType($type);

        parent::__construct(
            inputAttributes: [
                'wire:model' => $this->wireModel,
                'wire:model.defer' => $this->wireModelDefer,
                'wire:keydown.enter' => $this->wireKeydownEnter,
            ],
            name: $name,
            type: $type,
            class: $label ? $this->mergeClasses([$class, config('laravel-helpers.component.input.group_class')]) : $class,
            id: $id,
            value: $value,
            title: $title,
            placeholder: $placeholder,
            tooltip: $tooltip,
            append: $append,
            accept: $accept,
            autocomplete: $autocomplete,
            autofocus: $autofocus,
            disabled: $disabled,
            required: $required,
            addLocale: true,
        );
    }

    private function validateType(string $type): void
    {
        $availableTypes = array_flip([
            self::TYPE_TEXT,
            self::TYPE_HIDDEN,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_NUMERIC,
            self::TYPE_INTEGER,
            self::TYPE_EMAIL,
            self::TYPE_INTEGER,
            self::TYPE_PASSWORD,
            self::TYPE_FILE,
            self::TYPE_COLOR,
        ]);

        if (! isset($availableTypes[$type])) {
            throw new Exception("Input type cannot be '$type'!");
        }
    }
}
