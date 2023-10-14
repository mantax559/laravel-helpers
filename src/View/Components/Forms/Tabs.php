<?php

namespace Mantax559\LaravelHelpers\View\Components\Forms;

use Mantax559\LaravelHelpers\View\Components\Component;

class Tabs extends Component
{
    public array $tabs = [];

    public function __construct(
        public ?string $title1 = null,
        public ?string $title2 = null,
        public ?string $title3 = null,
        public ?string $title4 = null,
        public ?string $title5 = null,
        public ?string $title6 = null,
        public ?string $title7 = null,
        public ?string $title8 = null,
        public ?string $title9 = null,
        public ?string $content1 = null,
        public ?string $content2 = null,
        public ?string $content3 = null,
        public ?string $content4 = null,
        public ?string $content5 = null,
        public ?string $content6 = null,
        public ?string $content7 = null,
        public ?string $content8 = null,
        public ?string $content9 = null,
        public ?string $class = null,
    ) {
        parent::__construct('form');

        $this->addTabToTabs($title1, $content1);
        $this->addTabToTabs($title2, $content2);
        $this->addTabToTabs($title3, $content3);
        $this->addTabToTabs($title4, $content4);
        $this->addTabToTabs($title5, $content5);
        $this->addTabToTabs($title6, $content6);
        $this->addTabToTabs($title7, $content7);
        $this->addTabToTabs($title8, $content8);
        $this->addTabToTabs($title9, $content9);

        $this->class = $this->mergeClasses([$class, config('laravel-helpers.form.tabs.class')]);
    }

    private function addTabToTabs(string $title, string $content): void
    {
        if ($title && $content) {
            $this->tabs[] = [
                'title' => $title,
                'content' => $content,
            ];
        }
    }
}
