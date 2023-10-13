<x-form::input-group :name="$name" :class="$class" :prepend="$prepend" :append="$append">
    
    <x-form::label :id="$id" :title="$title" :required="$required"/>

    @isset($tooltip)
        <x-form::tooltip :title="$tooltip"/>
    @endisset

    <textarea class="{{ config('laravel-helpers.css.form.textarea.input') }}" {{ $attributes->merge($inputAttributes)}}>{{ $value }}</textarea>
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
