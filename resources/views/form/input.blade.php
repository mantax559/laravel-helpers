<x-form::input-group :name="$name" :class="$class" :append="$append">

    @isset($title)
        <x-form::label :id="$id" :title="$title" :required="$required"/>
    @endisset

    @isset($tooltip)
        <x-form::tooltip :title="$tooltip"/>
    @endisset

    <input {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.form.input.class'), config('laravel-helpers.form.error.input_class') => $hasError($name)]) }} />

</x-form::input-group>

@if(cmprstr($type, 'numeric'))
    @push('scripts')
        <script type="text/javascript">
            $('#{{ $id }}').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')
            });
        </script>
    @endpush
@elseif(cmprstr($type, 'integer'))
    @push('scripts')
        <script type="text/javascript">
            $('#{{ $id }}').on('input', function () {
                this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1')
            });
        </script>
    @endpush
@elseif(cmprstr($type, 'date') || cmprstr($type, 'datetime'))
    @push('scripts')
        <script type="text/javascript">
            $('#{{ $id }}').flatpickr({
                @if(cmprstr($type, 'datetime'))
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i',
                @else
                    dateFormat: 'Y-m-d',
                @endif
                locale: '{{ $locale }}',
            });
        </script>
    @endpush
    @once
        @push('cdn-header')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
        @endpush
        @push('cdn-footer')
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            @if(!cmprstr($locale, 'en'))
                <script type="text/javascript" src="https://npmcdn.com/flatpickr/dist/l10n/{{ $locale }}.js"></script>
            @endif
        @endpush
    @endonce
@endif
