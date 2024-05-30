<x-form::input-group :name="$name" :class="$class" :append="$append">

    @isset($title)
        <x-form::label :id="$id" :title="$title" :required="$required"/>
    @endisset

    @isset($tooltip)
        <x-form::tooltip :title="$tooltip"/>
    @endisset

    @if($ckeditor)
        <textarea {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.component.textarea.class'), config('laravel-helpers.component.error.input_class') => $hasError($name)]) }}>
            {{ $value }}
        </textarea>
    @else
        <textarea {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.component.textarea.class'), config('laravel-helpers.component.error.input_class') => $hasError($name)]) }}>{{ $value }}</textarea>
    @endif

</x-form::input-group>

@if($ckeditor)
    @push('scripts')
        <script type="text/javascript">
            ClassicEditor.create(document.querySelector('#{{ $id }}'), {
                language: '{{ $locale }}'
            });
        </script>
    @endpush

    @once
        @push('cdn-footer')
            <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
            @if(!cmprstr($locale, 'en'))
                <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/{{ $locale }}.js"></script>
            @endif
        @endpush
    @endonce
@endif
