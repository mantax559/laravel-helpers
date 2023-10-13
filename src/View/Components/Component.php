<?php

namespace Mantax559\LaravelHelpers\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

class Component extends BaseComponent
{
    public function __construct(protected string $namespace)
    {
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

    protected function getRandomId(): string
    {
        $length = config('laravel-helpers.random_id_length');

        return str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + $length / 32), 0, $length));
    }

    protected function mergeClasses(array $classes): string
    {
        return format_string(implode(' ', $classes));
    }
}
