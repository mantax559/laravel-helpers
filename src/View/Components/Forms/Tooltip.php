<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

class Tooltip extends FormComponent
{
    public function __construct(
        string $title,
        ?string $class = null,
        ?string $position = null,
        public ?string $icon = null,
    ) {
        $this->icon = $this->icon ?? config('laravel-helpers.css.form.tooltip.icon');

        parent::__construct(
            inputAttributes: [
                'data-toggle' => 'tooltip',
                'data-placement' => $position ?? config('laravel-helpers.css.form.tooltip.position'),
            ],
            class: $class ?? config('laravel-helpers.css.form.tooltip.color'),
            title: $title,
        );
    }
}
