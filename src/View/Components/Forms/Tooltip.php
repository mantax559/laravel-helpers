<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $title,
        public ?string $class = null,
        public ?string $icon = null,
        public ?string $position = null,
    ) {
        parent::__construct('form');

        $this->class = $this->mergeClasses([
            $class ?? config('laravel-helpers.form.tooltip.class'),
            $icon ?? config('laravel-helpers.form.tooltip.icon'),
        ]);
        $this->position = $position ?? config('laravel-helpers.form.tooltip.position');
    }
}
