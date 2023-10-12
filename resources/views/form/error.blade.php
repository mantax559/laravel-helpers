@error($name.'*', $bag)
    <div {{ $attributes->class(config('laravel-helpers.css.form.error')) }}>
        {{ $message }}
    </div>
@enderror
