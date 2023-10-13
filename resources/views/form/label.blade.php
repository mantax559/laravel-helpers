<label for="{{ $id }}" class="{{ config('laravel-helpers.css.form.label.class') }}">
    {{ $title }}
</label>
@if($required)
    <span class="text-danger">*</span>
@endif
