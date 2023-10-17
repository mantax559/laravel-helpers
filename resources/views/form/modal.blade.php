<div class="{{ config('laravel-helpers.component.modal.class') }}" id="{{ $id }}">
    <div class="{{ config('laravel-helpers.component.modal.dialog_class') }}">
        <div class="{{ config('laravel-helpers.component.modal.content_class') }}">
            <x-form::form :action="$action" :method="$method">
                <div class="{{ config('laravel-helpers.component.modal.header_class') }}">
                    <h5 class="{{ config('laravel-helpers.component.modal.title_class') }}">{{ $title }}</h5>
                </div>
                <div class="{{ config('laravel-helpers.component.modal.body_class') }}">{!! $slot !!}</div>
                <div class="{{ config('laravel-helpers.component.modal.footer_class') }}">
                    <button type="button" class="{{ config('laravel-helpers.component.modal.close_button_class') }}" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    @isset($submitText)
                        <button {{ $attributes->merge($buttonAttributes) }}>{{ $submitText }}</button>
                    @endisset
                </div>
            </x-form::form>
        </div>
    </div>
</div>
