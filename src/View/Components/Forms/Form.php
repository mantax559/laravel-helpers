<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Form extends Component
{
    public function __construct(
        public string $method,
        public ?string $action = null,
    ) {
        parent::__construct('form');
    }
}
