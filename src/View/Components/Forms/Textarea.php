<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

class Textarea extends FormComponent
{
    public function __construct(
        string $name,
        string $class = null,
        string $id = null,
        string $value = null,
        string $title = null,
        string $placeholder = null,
        string $tooltip = null,
        string $autocomplete = null,
        string $append = null,
        bool $autofocus = false,
        bool $disabled = false,
        bool $required = false,
        int $rows = 2,
        public bool $ckeditor = false,
        public ?string $locale = null,
    ) {
        $this->locale = $this->locale ?? app()->getLocale();

        parent::__construct(
            inputAttributes: [
                'rows' => $rows,
            ],
            name: $name,
            class: $class,
            id: $id,
            value: $value,
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
