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

    protected function convertNameToId(string $name): string
    {
        $name = str_replace([']'], '', $name);
        $name = str_replace(['['], '_', $name);
        $name = preg_replace('/[^a-zA-Z1-9_]/', '', $name);
        $name = str_replace(['_'], ' ', $name);
        $name = format_string(format_string($name, 2), 7);

        return $name;
    }

    protected function mergeClasses(array $classes): string
    {
        return format_string(implode(' ', $classes));
    }
}
