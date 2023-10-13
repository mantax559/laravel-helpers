@error("$name*", $bag)
    <div class="{{ config('laravel-helpers.form.error.message_class') }}">
        {{ $message }}
    </div>
@enderror
