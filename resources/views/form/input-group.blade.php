<div class="{{ $class }}">
    {{ $slot }}

    @if($hasError($name))
        <x-form::error :name="$name"/>
    @endif

    @isset($append)
        <div class="{{ config('laravel-helpers.css.form.input-group.append') }}">
            {!! $append !!}
        </div>
    @endisset
</div>
