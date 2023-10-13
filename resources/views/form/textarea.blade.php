<div class="{{ $class }}">

    @isset($title)
        <label for="{{ $id }}" class="{{ config('laravel-helpers.css.form.textarea.label') }}">{{ $title }}</label>
    @endisset

    @isset($tooltip)
        <x-form::tooltip title="{{ $tooltip }}"/>
    @endisset

    <textarea {{ $attributes->merge($inputAttributes)->class([
                    config('laravel-helpers.css.form.textarea.input'),
                    config('laravel-helpers.css.form.error.inline.input') => $hasError($name)
             ])}}>{{ $value }}</textarea>

    @if($hasError($name))
        <x-form::error name="{{ $name }}"/>
    @endif
</div>

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
