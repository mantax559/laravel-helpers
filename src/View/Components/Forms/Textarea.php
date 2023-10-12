<?php

namespace App\View\Components\Forms;

class Textarea extends FormComponent
{
    public function __construct(
        public bool $ckeditor = true,
        public int $rows = 2,
        string $name,
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
    ) {
        parent::__construct(
            $name,
            $class,
            $id,
            $value,
            $title,
            $placeholder,
            $tooltip,
            $autocomplete,
            $autofocus,
            $disabled,
            $required
        );
    }
}
