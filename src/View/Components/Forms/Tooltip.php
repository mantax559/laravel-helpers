<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $title,
        public ?string $class = null,
        public ?string $id = null,
        public ?string $icon = null,
        public ?string $position = null,
    ) {
        parent::__construct('form');

        $this->title = escape_html($title);
        $this->class = $this->mergeClasses([
            $class ?? config('laravel-helpers.component.tooltip.class'),
            $icon ?? config('laravel-helpers.component.tooltip.icon'),
        ]);
        $this->position = $position ?? config('laravel-helpers.component.tooltip.position');
    }
}
