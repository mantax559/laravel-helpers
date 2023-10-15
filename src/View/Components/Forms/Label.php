<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Label extends Component
{
    public function __construct(
        public string $title,
        public ?string $id = null,
        public ?string $class = null,
        public bool $required = false,
    ) {
        parent::__construct('form');

        $this->class = $this->mergeClasses([
            $this->class,
            config('laravel-helpers.form.label.class'),
        ]);
    }
}
