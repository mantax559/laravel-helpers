<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\Traits\HandlesValidationErrors;
use Mantax559\LaravelHelpers\View\Components\Component;

abstract class FormComponent extends Component
{
    use HandlesValidationErrors;

    protected const TYPE_CHECKBOX = 'checkbox';

    protected const TYPE_RADIO = 'radio';

    public string $locale;

    public function __construct(
        public array $inputAttributes = [],
        public ?string $name = null,
        public ?string $type = null,
        public ?string $class = null,
        public ?string $id = null,
        public ?string $value = null,
        public ?string $title = null,
        public ?string $placeholder = null,
        public ?string $tooltip = null,
        public ?string $autocomplete = null,
        public ?string $append = null,
        public string|array|null $checked = null,
        public ?bool $autofocus = null,
        public ?bool $disabled = null,
        public ?bool $required = null,
        bool $addLocale = false,
    ) {
        parent::__construct('form');

        $oldName = $this->convertBracketsToDots($this->name);
        if (cmprstr($this->type, self::TYPE_CHECKBOX) || cmprstr($this->type, self::TYPE_RADIO)) {
            $this->checked = old($oldName, $this->checked) ?? null;
        } else {
            $this->value = old($oldName, $this->value) ?? null;
            $this->placeholder = $this->placeholder ?? ($this->title ?? null);
        }

        $this->locale = $addLocale ? app()->getLocale() : null;
        $this->id = $this->id ?? $this->getRandomId();

        $attributes = [
            'name' => $this->name,
            'type' => $this->type,
            'id' => $this->id,
            'value' => $this->value,
            'title' => $this->title,
            'placeholder' => $this->placeholder,
            'autocomplete' => $this->autocomplete,
            'checked' => (is_array($this->checked) && in_array($this->value, $this->checked)) || cmprstr($this->value, $this->checked),
            'autofocus' => $this->autofocus,
            'disabled' => $this->disabled,
            'required' => $this->required,
        ];

        foreach ($attributes as $attribute => $value) {
            $this->addAttributesToInput($attribute, $value);
        }
    }

    private function addAttributesToInput(string $key, bool|string|null $value): void
    {
        if ($value) {
            if (is_bool($value)) {
                $this->inputAttributes[$key] = $key;
            } else {
                $this->inputAttributes[$key] = $value;
            }
        }
    }
}
