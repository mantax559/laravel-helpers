<x-form::input-group :name="$name" :class="$class">

    <input {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.form.checkbox.class'), config('laravel-helpers.form.error.input_class') => $hasError($name)]) }} />

    @isset($title)
        <x-form::label :id="$id" :title="$title"/>
    @endisset

</x-form::input-group>
