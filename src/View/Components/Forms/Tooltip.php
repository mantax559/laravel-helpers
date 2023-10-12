<?php

namespace App\View\Components\Forms;

class Tooltip extends FormComponent
{
    public function __construct(
        string $class = null,
        string $title = null,
        public ?string $icon = null,
    ) {
        $this->icon = !empty($this->icon) ? $this->icon : config('laravel-helpers.css.form.tooltip.icon');

        parent::__construct(
            inputAttributes: [
                'icon' => $this->icon,
            ],
            class: $class,
            title: $title,
        );
    }
}
