<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\Traits\HandlesValidationErrors;
use Mantax559\LaravelHelpers\View\Components\Component;

abstract class FormComponent extends Component
{
    use HandlesValidationErrors;

    public function __construct(
        public array $inputAttributes = [],
        public ?string $name = null,
        public ?string $class = null,
        public ?string $id = null,
        public ?string $value = null,
        public ?string $title = null,
        public ?string $placeholder = null,
        public ?string $tooltip = null,
        public ?string $autocomplete = null,
        public ?string $prepend = null,
        public ?string $append = null,
        public bool $autofocus = false,
        public bool $disabled = false,
        public bool $required = false,
    ) {
        parent::__construct('form');

        $this->id = ! empty($this->id) ? $this->id : $this->getRandomId();
        $this->placeholder = $this->placeholder ?? ($this->title ?? null);
        $this->value = old($this->convertBracketsToDots($this->name), $this->value) ?? null;
        $this->autocomplete = ! empty($this->autocomplete) ? 'on' : 'off';

        $this->inputAttributes = array_merge(
            $this->inputAttributes,
            [
                'name' => $this->name,
                'class' => $this->class,
                'id' => $this->id,
                'value' => $this->value,
                'title' => $this->title,
                'placeholder' => $this->placeholder,
                'tooltip' => $this->tooltip,
                'autocomplete' => $this->autocomplete,
            ]
        );

        if ($this->autofocus) {
            $this->inputAttributes['autofocus'] = 'autofocus';
        }

        if ($this->disabled) {
            $this->inputAttributes['disabled'] = 'disabled';
        }

        if ($this->required) {
            $this->inputAttributes['required'] = 'required';
        }
    }
}
