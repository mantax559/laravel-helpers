<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Label extends Component
{
    public function __construct(
        public string $id,
        public string $title,
        public bool $required = false,
    ) {
        parent::__construct('form');
    }
}
