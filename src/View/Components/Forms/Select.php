<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Illuminate\Support\Collection;

class Select extends FormComponent
{
    public function __construct(
        string $name,
        ?string $class = null,
        ?string $id = null,
        ?string $title = null,
        ?string $placeholder = null,
        ?string $tooltip = null,
        ?string $append = null,
        bool $autofocus = false,
        bool $disabled = false,
        bool $required = false,
        public string|array|Collection|null $selected = null,
        public ?string $wireModel = null,
        public ?string $wireModelDefer = null,
        public ?string $api = null,
        public Collection|array|null $collection = null,
        public bool $multiple = false,
    ) {
        if (empty($this->collection) || is_array($this->collection)) {
            $this->collection = collect($this->collection);
        }

        parent::__construct(
            inputAttributes: [
                'wire:model' => $this->wireModel,
                'wire:model.defer' => $this->wireModelDefer,
            ],
            name: $name,
            class: $class,
            id: $id,
            title: $title,
            placeholder: $placeholder,
            tooltip: $tooltip,
            append: $append,
            selected: $selected,
            autofocus: $autofocus,
            disabled: $disabled,
            required: $required,
            addLocale: true,
        );
    }
}
