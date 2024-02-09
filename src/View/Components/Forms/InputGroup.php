<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\Traits\HandleValidationErrorTrait;
use Mantax559\LaravelHelpers\View\Components\Component;

class InputGroup extends Component
{
    use HandleValidationErrorTrait;

    public function __construct(
        public string $name,
        public ?string $class = null,
        public ?string $append = null,
    ) {
        parent::__construct('form');

        $this->name = $this->convertBracketsToDots($name);
    }
}
