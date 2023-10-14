<x-form::input-group :class="config('laravel-helpers.form.checkbox.group_class')" :name="$name" :class="$class">

    <input {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.form.checkbox.class'), config('laravel-helpers.form.error.input_class') => $hasError($name)]) }} />

    @isset($title)
        <x-form::label :class="config('laravel-helpers.form.checkbox.label_class')" :id="$id" :title="$title"/>
    @endisset

</x-form::input-group>
