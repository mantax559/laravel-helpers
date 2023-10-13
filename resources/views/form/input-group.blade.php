<div class="{{ $class }}">
    @isset($prepend)
        {!! $prepend !!}
    @endisset

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
