<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    protected string $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function render(): View|Factory|Htmlable|string|Closure|Application
    {
        $alias = Str::kebab(class_basename($this));

        return view("laravel-helpers::$this->namespace.$alias");
    }

    protected function convertBracketsToDots(string $name): string
    {
        return rtrim(str_replace(['[', ']'], ['.', ''], $name), '.');
    }
}
