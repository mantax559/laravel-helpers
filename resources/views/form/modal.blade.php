<div class="{{ config('laravel-helpers.form.modal.class') }}" id="{{ $id }}">
    <div class="{{ config('laravel-helpers.form.modal.dialog_class') }}">
        <div class="{{ config('laravel-helpers.form.modal.content_class') }}">
            <x-form::form :action="$action" :method="$method">
                <div class="{{ config('laravel-helpers.form.modal.header_class') }}">
                    <h5 class="{{ config('laravel-helpers.form.modal.title_class') }}">{{ $title }}</h5>
                </div>
                <div class="{{ config('laravel-helpers.form.modal.body_class') }}">{!! $slot !!}</div>
                <div class="{{ config('laravel-helpers.form.modal.footer_class') }}">
                    <button type="button" class="{{ config('laravel-helpers.form.modal.close_button_class') }}" data-bs-dismiss="modal">X</button>
                    @isset($submitText)
                        <button {{ $attributes->merge($buttonAttributes) }}>{{ $submitText }}</button>
                    @endisset
                </div>
            </x-form::form>
        </div>
    </div>
</div>
