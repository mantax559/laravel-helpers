<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

class Select extends FormComponent
{
    public string $locale;

    public function __construct(
        string $name,
        string $class = null,
        string $id = null,
        string $selected = null,
        string $title = null,
        string $placeholder = null,
        string $tooltip = null,
        string $autocomplete = null,
        string $append = null,
        bool $autofocus = false,
        bool $disabled = false,
        bool $required = false,
        public ?string $wireModel = null,
        public ?string $wireModelDefer = null,
        public ?string $api = null,
        public array $data = [],
        public bool $multiple = false,
    ) {
        $this->locale = $this->locale ?? app()->getLocale();

        parent::__construct(
            inputAttributes: [
                'wire:model' => $this->wireModel,
                'wire:model.defer' => $this->wireModelDefer,
            ],
            name: $name,
            class: $class,
            id: $id,
            value: $selected,
            title: $title,
            placeholder: $placeholder,
            tooltip: $tooltip,
            autocomplete: $autocomplete,
            append: $append,
            autofocus: $autofocus,
            disabled: $disabled,
            required: $required
        );
    }
}
