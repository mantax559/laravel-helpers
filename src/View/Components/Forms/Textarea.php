<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

class Textarea extends FormComponent
{
    public function __construct(
        string $name = null,
        string $class = null,
        string $id = null,
        string $value = null,
        string $title = null,
        string $placeholder = null,
        string $tooltip = null,
        bool $autocomplete = false,
        bool $autofocus = false,
        bool $disabled = false,
        bool $required = true,
        public bool $ckeditor = true,
        public int $rows = 2,
        public ?string $locale = null,
    ) {
        $this->locale = $this->locale ?? app()->getLocale();

        parent::__construct(
            inputAttributes: [
                'rows' => $rows,
            ],
            name: $name,
            class: $this->mergeClasses([config('laravel-helpers.css.form.textarea.wrap'), $class]),
            id: $id,
            value: $value,
            title: $title,
            placeholder: $placeholder,
            tooltip: $tooltip,
            autocomplete: $autocomplete,
            autofocus: $autofocus,
            disabled: $disabled,
            required: $required
        );
    }
}
