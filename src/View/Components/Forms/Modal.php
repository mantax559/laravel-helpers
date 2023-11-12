<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Modal extends Component
{
    public array $buttonAttributes = [];

    public function __construct(
        public string $id,
        public string $title,
        public ?string $class = null,
        public ?string $action = null,
        public ?string $method = null,
        public ?string $submitText = null,
        public ?string $submitName = null,
        public ?string $submitValue = null,
    ) {
        parent::__construct('form');

        $this->class = $this->mergeClasses([
            config('laravel-helpers.component.modal.dialog_class'),
            $class,
        ]);

        $this->buttonAttributes = [
            'class' => $this->mergeClasses([
                config('laravel-helpers.component.modal.submit_button_class'),
                'btn-'.(cmprstr($method, 'DELETE') ? 'danger' : 'primary'),
            ]),
        ];

        $this->addAttributesToButton('name', $this->submitName);
        $this->addAttributesToButton('value', $this->submitValue);
    }

    private function addAttributesToButton(string $key, ?string $value): void
    {
        if ($value) {
            $this->buttonAttributes[$key] = $value;
        }
    }
}
