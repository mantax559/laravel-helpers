@isset($title)
    <label for="{{ $id }}" class="{{ config('laravel-helpers.label.class') }}">
        {{ $title }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endisset
