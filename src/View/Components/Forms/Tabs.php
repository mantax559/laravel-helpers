<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Tabs extends Component
{
    public function __construct(
        public ?string $tabTitle1 = null,
        public ?string $tabTitle2 = null,
        public ?string $tabTitle3 = null,
        public ?string $tabTitle4 = null,
        public ?string $tabTitle5 = null,
        public ?string $tabTitle6 = null,
        public ?string $tabTitle7 = null,
        public ?string $tabTitle8 = null,
        public ?string $tabTitle9 = null,
        public ?string $tabContent1 = null,
        public ?string $tabContent2 = null,
        public ?string $tabContent3 = null,
        public ?string $tabContent4 = null,
        public ?string $tabContent5 = null,
        public ?string $tabContent6 = null,
        public ?string $tabContent7 = null,
        public ?string $tabContent8 = null,
        public ?string $tabContent9 = null,
        public ?string $class = null,
    ) {
        parent::__construct('form');

        $this->class = $this->mergeClasses([$class, config('laravel-helpers.form.tabs.class')]);
    }
}
