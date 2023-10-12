@props(['class', 'title', 'tooltip', 'id', 'placeholder', 'name', 'rows', 'autocompleteOff', 'autofocus','disabled', 'required', 'value', 'ckeditor'])

<div {{ $attributes->class([config('laravel-helpers.css.form.textarea.group'), $class ?? null]) }}>

    @isset($title)
        <label for="{{ $id ?? make_unique_id($name) }}" class="{{ config('laravel-helpers.css.form.textarea.label') }}">{{ $title }}</label>
    @endisset

    @isset($tooltip)
        <x-tooltip title="{{ $tooltip }}"></x-tooltip>
    @endisset

    <textarea class="form-control @error(name_to_old($name)) is-invalid @enderror"
              id="{{ $id ?? make_unique_id($name) }}"
              placeholder="{{ $placeholder ?? ($title ?? __('Įveskite...')) }}"
              name="{{ $name }}"
              rows="{{ $rows ?? 2 }}"
              @isset($autocompleteOff) autocomplete="off" @endisset
              {{ isset($autofocus) ? 'autofocus' : null }}
              {{ isset($disabled) ? 'disabled' : null }}
              {{ isset($required) ? 'required' : null }}>
              {!! old(name_to_old($name), $value) !!}
    </textarea>

    @error(name_to_old($name))
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
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
