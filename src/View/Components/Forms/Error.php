<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Error extends Component
{
    public const DEFAULT_ERROR_BAG = 'default';

    public function __construct(
        public string $name,
        public string $bag = self::DEFAULT_ERROR_BAG,
    ) {
        parent::__construct('form');

        $this->name = $this->convertBracketsToDots($name);
    }
}
