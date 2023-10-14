<?php

namespace Mantax559\LaravelHelpers\Traits;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Mantax559\LaravelHelpers\View\Components\Forms\Error;

use function request;

trait HandlesValidationErrors
{
    protected function getErrorBag(string $bag = Error::DEFAULT_ERROR_BAG): MessageBag
    {
        $bags = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        return $bags->getBag($bag);
    }

    public function hasError(string $name, string $bag = Error::DEFAULT_ERROR_BAG): bool
    {
        $name = str_replace(['[', ']'], ['.', ''], Str::before($name, '[]'));

        $errorBag = $this->getErrorBag($bag);

        return $errorBag->has($name) || $errorBag->has("$name.*");
    }
}
