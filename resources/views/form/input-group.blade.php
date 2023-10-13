<div class="{{ config('laravel-helpers.css.form.input-group.class') }}">
    @isset($prepend)
        {!! $prepend !!}
    @endisset

    {{ $slot }}

    @if($hasError($name))
        <x-form::error :name="$name"/>
    @endif

    @isset($append)
        {!! $append !!}
    @endisset
</div>
