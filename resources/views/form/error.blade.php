@error("$name*", $bag)
    <div class="{{ config('laravel-helpers.component.error.message_class') }}">
        {{ $message }}
    </div>
@enderror
