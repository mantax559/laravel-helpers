<?php

namespace App\View\Components\Forms;

use App\View\Components\Component;

class Error extends Component
{
    public function __construct(
        public ?string $name = null,
        public ?string $bag = null,
    ) {
        parent::__construct('form');

        $this->name = $this->convertBracketsToDots($name);
        $this->bag = $this->bag ?? config('laravel-helpers.css.form.error.bag');
    }
}
