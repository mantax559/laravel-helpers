<div {{ $attributes->class([config('laravel-helpers.css.form.input-group')]) }} >

    {{ $slot }}

    @if($hasError($name))
        <x-form::error :name="$name"/>
    @endif
</div>
