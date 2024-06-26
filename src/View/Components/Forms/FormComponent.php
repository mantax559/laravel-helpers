<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Illuminate\Support\Collection;
use Mantax559\LaravelHelpers\Traits\HandleValidationErrorTrait;
use Mantax559\LaravelHelpers\View\Components\Component;

abstract class FormComponent extends Component
{
    use HandleValidationErrorTrait;

    protected const TYPE_CHECKBOX = 'checkbox';

    protected const TYPE_RADIO = 'radio';

    protected const TYPE_TEXT = 'text';

    protected const TYPE_HIDDEN = 'hidden';

    protected const TYPE_DATE = 'date';

    protected const TYPE_DATETIME = 'datetime';

    protected const TYPE_NUMERIC = 'numeric';

    protected const TYPE_INTEGER = 'integer';

    protected const TYPE_EMAIL = 'email';

    protected const TYPE_PASSWORD = 'password';

    protected const TYPE_FILE = 'file';

    protected const TYPE_COLOR = 'color';

    public ?string $locale;

    public function __construct(
        public array $inputAttributes = [],
        public ?string $name = null,
        public ?string $type = null,
        public ?string $class = null,
        public ?string $id = null,
        public array|string|null $value = null,
        public ?string $title = null,
        public ?string $placeholder = null,
        public ?string $tooltip = null,
        public ?string $append = null,
        public ?string $accept = null,
        public string|array|Collection|null $selected = null,
        public string|array|Collection|null $checked = null,
        public ?bool $autocomplete = null,
        public ?bool $autofocus = null,
        public ?bool $disabled = null,
        public ?bool $required = null,
        bool $addLocale = false,
    ) {
        parent::__construct('form');

        if ($this->checked instanceof Collection) {
            $this->checked = $this->checked->toArray();
        }

        if ($this->selected instanceof Collection) {
            $this->selected = $this->selected->toArray();
        }

        $oldName = $this->convertBracketsToDots($this->name);
        if (cmprstr($this->type, self::TYPE_CHECKBOX) || cmprstr($this->type, self::TYPE_RADIO)) {
            $this->checked = old($oldName, $this->checked) ?? null;
        } else {
            $this->selected = old($oldName, $this->selected) ?? null;
            $this->value = old($oldName, $this->value) ?? null;
            $this->placeholder = $this->placeholder ?? ($this->title ?? null);
        }

        if (is_array($this->value)) {
            $this->value = json_encode($this->value);
        }

        $this->locale = $addLocale ? app()->getLocale() : null;
        $this->id = $this->id ?? $this->getRandomId();

        $attributes = [
            'name' => $this->name,
            'type' => $this->getAdjustedType(),
            'id' => $this->id,
            'value' => escape_html($this->value),
            'title' => $this->title,
            'placeholder' => $this->placeholder,
            'accept' => $this->accept,
            'checked' => isset($this->checked) ? ($this->checked && (is_array($this->checked) ? in_array($this->value, $this->checked) : cmprstr($this->value, $this->checked))) : null,
            'autocomplete' => isset($this->autocomplete) ? ($this->autocomplete ? 'on' : 'off') : null,
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
        if ($value === '0' || $value) {
            if (is_bool($value)) {
                $this->inputAttributes[$key] = $key;
            } else {
                $this->inputAttributes[$key] = $value;
            }
        }
    }

    private function getAdjustedType(): ?string
    {
        if ($this->type) {
            $adjustableTypes = array_flip([self::TYPE_NUMERIC, self::TYPE_INTEGER]);

            if (isset($adjustableTypes[$this->type])) {
                return self::TYPE_TEXT;
            }

            return $this->type;
        }

        return null;
    }
}
