<?php

namespace App\View\Components\Forms;

class Tooltip extends FormComponent
{
    public function __construct(
        ?string $class = null,
        ?string $title = null,
        public ?string $icon = null,
        public ?string $position = null,
    ) {
        $this->icon = $this->icon ?? config('laravel-helpers.css.form.tooltip.icon');
        $this->position = $this->position ?? config('laravel-helpers.css.form.tooltip.position');

        parent::__construct(
            inputAttributes: [
                'data-toggle' => 'tooltip',
                'data-placement' => $this->position,
            ],
            class: $class ?? config('laravel-helpers.css.form.tooltip.color'),
            title: $title,
        );
    }
}
