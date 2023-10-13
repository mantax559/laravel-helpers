<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\Traits\HandlesValidationErrors;
use Mantax559\LaravelHelpers\View\Components\Component;

abstract class FormComponent extends Component
{
    use HandlesValidationErrors;

    protected const TYPE_CHECKBOX = 'checkbox';

    protected const TYPE_RADIO = 'radio';

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
        public ?bool $autofocus = null,
        public ?bool $disabled = null,
        public ?bool $required = null,
    ) {
        parent::__construct('form');

        if (!cmprstr($this->type, self::TYPE_CHECKBOX) && !cmprstr($this->type, self::TYPE_RADIO)) {
            $this->placeholder = $this->placeholder ?? ($this->title ?? null);
        }

        $this->name = $this->name ?? (!empty($this->title) ? $this->convertTitleToName($this->title) : null);
        $this->id = $this->id ?? $this->getRandomId();
        $this->value = old($this->convertBracketsToDots($this->name), $this->value) ?? null;

        $values = [
            'name' => $this->name,
            'type' => $this->type,
            'class' => $this->class,
            'id' => $this->id,
            'value' => $this->value,
            'title' => $this->title,
            'placeholder' => $this->placeholder,
            'autocomplete' => $this->autocomplete,
            'autofocus' => $this->autofocus,
            'disabled' => $this->disabled,
            'required' => $this->required,
        ];

        foreach ($values as $attribute => $value) {
            $this->addToInputAttributesIfNotEmpty($attribute, $value);
        }
    }

    private function addToInputAttributesIfNotEmpty(string $key, bool|string|array|null $value): void
    {
        if ($value) {
            $this->inputAttributes[$key] = $value;
        }
    }
}
