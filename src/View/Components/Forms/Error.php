<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Error extends Component
{
    public function __construct(
        public string $name,
        public string $bag = 'default',
    ) {
        parent::__construct('form');

        $this->name = $this->convertBracketsToDots($name);
    }
}
