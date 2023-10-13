<x-form::input-group :name="$name" :class="$class" :append="$append">

    @isset($title)
        <x-form::label :id="$id" :title="$title" :required="$required"/>
    @endisset

    @isset($tooltip)
        <x-form::tooltip :title="$tooltip"/>
    @endisset

    <textarea {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.css.form.textarea.class'), config('laravel-helpers.css.form.error.inline.input') => $hasError($name)]) }}>
        {{ $value }}
    </textarea>
</x-form::input-group>

@if($ckeditor)
    @push('scripts')
        <script type="text/javascript">
            ClassicEditor.create(document.querySelector('#{{ $id }}'), {
                language: '{{ $locale }}'
            });
        </script>
    @endpush
@endif

@once
    @push('cdn-footer')
        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
        @if(!cmprstr($locale, 'en'))
            <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/translations/{{ $locale }}.js"></script>
        @endif
    @endpush
@endonce
