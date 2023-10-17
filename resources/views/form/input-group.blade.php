<div class="{{ $class }}">
    {{ $slot }}

    @if($hasError($name))
        <x-form::error :name="$name"/>
    @endif

    @isset($append)
        <div class="{{ config('laravel-helpers.component.input_group.append_class') }}">
            {!! $append !!}
        </div>
    @endisset
</div>
