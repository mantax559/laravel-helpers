<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class ModalButton extends Component
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $class = null,
    ) {
        parent::__construct('form');

        $this->class = $this->class ?? config('laravel-helpers.form.modal_button.class');
    }
}
