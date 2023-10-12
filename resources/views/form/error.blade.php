@error("$name*", $bag)
    <div {{ $attributes->class(config('laravel-helpers.css.form.error.inline.div')) }}>
        {{ $message }}
    </div>
@enderror
