<label for="{{ $id }}" class="{{ config('laravel-helpers.css.form.label.class') }}">
    {{ $title }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
