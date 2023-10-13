<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

class Tooltip extends FormComponent
{
    public function __construct(
        string $class = null,
        string $title = null,
        string $position = null,
        string $icon = null,
    ) {
        parent::__construct(
            inputAttributes: [
                'data-toggle' => 'tooltip',
                'data-placement' => $position ?? config('laravel-helpers.css.form.tooltip.position'),
            ],
            class: $this->mergeClasses([
                $class ?? config('laravel-helpers.css.form.tooltip.color'),
                $icon ?? config('laravel-helpers.css.form.tooltip.icon'),
            ]),
            title: $title,
        );
    }
}
