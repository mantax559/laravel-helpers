<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\Traits\HandlesValidationErrors;
use Mantax559\LaravelHelpers\View\Components\Component;

class Label extends Component
{
    use HandlesValidationErrors;

    public function __construct(
        public string $id,
        public ?string $title = null,
        public bool $required = false,
    ) {
        parent::__construct('form');
    }
}
