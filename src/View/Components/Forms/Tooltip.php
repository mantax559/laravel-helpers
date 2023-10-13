<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $title,
        public ?string $class = null,
        public ?string $position = null,
        public ?string $icon = null,
    ) {
        parent::__construct('form');

        $this->class = $this->mergeClasses([
            $class ?? config('laravel-helpers.css.form.tooltip.color'),
            $icon ?? config('laravel-helpers.css.form.tooltip.icon'),
        ]);
        $this->position = $position ?? config('laravel-helpers.css.form.tooltip.position');
    }
}
