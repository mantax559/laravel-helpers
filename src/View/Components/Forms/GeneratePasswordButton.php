<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class GeneratePasswordButton extends Component
{
    public string $id;

    public function __construct(
        public string $buttonText,
        public string $buttonSuccessText,
        public string $passwordInputId,
        public ?string $confirmationPasswordInputId = null,
        public ?string $class = null,
        public ?string $icon = null,
    ) {
        parent::__construct('form');

        $this->class = $this->class ?? config('laravel-helpers.component.generate_password_button.class');
        $this->icon = $this->icon ?? config('laravel-helpers.component.generate_password_button.icon');
        $this->id = $this->getRandomId();
    }
}
