<div {{ $attributes->class([config('laravel-helpers.css.form.textarea.wrap'), $class ?? null]) }}>

    @isset($title)
        <label for="{{ $id ?? make_unique_id($name) }}" class="{{ config('laravel-helpers.css.form.textarea.label') }}">{{ $title }}</label>
    @endisset

    {{--@isset($tooltip)
        <x-tooltip title="{{ $tooltip }}"></x-tooltip>
    @endisset--}}

    <textarea {{ $attributes->merge($inputAttributes)
                 ->class([
                    config('laravel-helpers.css.form.textarea.input'),
                    config('laravel-helpers.css.form.error.inline.div') => $hasError($name)
                 ])}}>{{ $value }}</textarea>

    @if($hasError($name))
        <x-form::error :name="$name"/>
    @endif
</div>

@isset($ckeditor)
    @push('scripts')
        <script type="text/javascript">
            ClassicEditor.create(document.querySelector('#{{ $id ?? make_unique_id($name) }}'), {
                language: '{{ app()->getLocale() }}'
            });
        </script>
    @endpush
@endisset

@once
    @push('cdn-footer')
        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
        @if(!cmprstr(app()->getLocale(), 'en'))
            <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/translations/{{ app()->getLocale() }}.js"></script>
        @endif
    @endpush
@endonce
