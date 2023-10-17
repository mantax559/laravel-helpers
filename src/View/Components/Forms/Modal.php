<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Modal extends Component
{
    public array $buttonAttributes = [];

    public function __construct(
        public string $action,
        public string $method,
        public string $id,
        public string $title,
        public ?string $submitText = null,
        public ?string $submitName = null,
        public ?string $submitValue = null,
    ) {
        parent::__construct('form');

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
            $this->buttonAttributes[$key] = $key;
        }
    }
}
