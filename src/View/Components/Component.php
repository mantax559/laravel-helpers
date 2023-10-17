<?php

namespace Mantax559\LaravelHelpers\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
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
        return chr(rand(97, 122)) . substr(
                str_shuffle(
                    substr(
                        str_repeat(
                            md5(mt_rand()),
                            round(2 + config('laravel-helpers.component.id_length') / 32)
                        ),
                        0,
                        config('laravel-helpers.component.id_length')
                    )
                ),
                1
            );
    }

    protected function mergeClasses(array $classes): string
    {
        return format_string(implode(' ', $classes));
    }
}
