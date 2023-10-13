@error("$name*", $bag)
    <div class="{{ config('laravel-helpers.css.form.error.inline.div') }}">
        {{ $message }}
    </div>
@enderror
