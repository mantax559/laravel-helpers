<?php

namespace App\View\Components\Forms;

use App\Traits\HandlesValidationErrors;
use App\View\Components\Component;

abstract class FormComponent extends Component
{
    use HandlesValidationErrors;

    public function __construct(
        public string $name,
        public ?string $class,
        public ?string $id,
        public ?string $value,
        public ?string $title,
        public ?string $placeholder,
        public ?string $tooltip,
        bool $autocomplete,
        bool $autofocus,
        bool $disabled,
        bool $required,
    ) {
        parent::__construct('form');

        $this->value = old($this->convertBracketsToDots($name), $value) ?? null;
    }
}
